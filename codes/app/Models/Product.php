<?php

namespace App\Models;

use App\Size;
use App\Brand;
use App\Color;
use App\Gender;
use Carbon\Carbon;
use App\Productsku;
use App\Productcolor;
use App\ProductReview;
use App\ProductCategory;
use App\ProductSubcategory;
use TCG\Voyager\Models\User;
use TCG\Voyager\Traits\Resizable;
use Illuminate\Support\Facades\Auth;
use TCG\Voyager\Traits\Translatable;
use Illuminate\Support\Facades\Config;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    use Resizable;
    use Translatable;
    use HasImpression;

    protected $translatable = ['name', 'description'];
    protected $perPage = 50;

    public function scopeRoleWise($query)
    {

        return $query
            ->when(auth()->user()->hasRole(['admin', 'Client']), function ($query) {

                return $query;

            })
            ->when(auth()->user()->hasRole(['Vendor']), function ($query) {

                return $query
                    ->where('seller_id', auth()->user()->id);

            })
            ->when(!auth()->user()->hasRole(['admin', 'Client', 'Vendor']), function ($query) {

                return $query->where('created_by', auth()->user()->id);

            })
            ->when(request('type') == 'regular', function ($query) {

                return $query->where('customize_images', null);

            })
            ->when(request('type') == 'customized', function ($query) {


                return $query->where('customize_images', '!==', null);

            })
            ->when(request('filter') == 'activeproducts', function ($query) {

                return $query->where('admin_status', 'Accepted');

            })
            ->when(request('filter') == 'inactiveproducts', function ($query) {


                $query->whereNotIn('admin_status', ['Accepted', 'Pending For Verification', 'Updated']);

            })
            ->when(request('filter') == 'pendingforverificationproducts', function ($query) {
                return $query->whereIn('admin_status', ['Pending For Verification', 'Updated']);
            })
            ->when(request('filter') == 'outofstockproducts', function ($query) {
                return $query->whereHas('productskus', function ($q) {
                    $q->where('available_stock', '<=', 0)->where('status', 1);
                });
            })
            ->orderBy('updated_at', 'desc');

        // return $query;
    }

    public function save(array $options = [])
    {
        /**
         * If vendor saves
         * If the product is accepted (already approved)
         * Then label as updated
         */

        if (auth()->user()->hasRole(['Vendor'])) {
            if ($this->seller_id != null) {
                $this->admin_status = 'Updated';
            }
        }


        if (empty($this->category_id)) {
            return redirect()->back()->with(['error', 'Category not selected']);
        }

        if (empty($this->subcategory_id)) {
            return redirect()->back()->with(['error', 'Subcategory not selected']);
        }

        // If no author has been assigned, assign the current user's id as the author of the post
        if (!$this->created_by && Auth::user()) {
            $this->created_by = Auth::user()->id;
        }

        if (!$this->seller_id && Auth::user()) {
            $this->seller_id = Auth::user()->id;
        }

        parent::save();

    }

    public function createskus($id)
    {
        /**
         * Get product info
         * Create skus
         */

        $product = Product::where('id', $id)->with(['sizes', 'colors'])->first();

        foreach ($product->sizes as $size) {
            if (Config::get('icrm.product_sku.color') == 1) {
                // add color as a sku field
                foreach ($product->colors as $color) {
                    /**
                     * Check if the same sku is available or not
                     * If available then dont create new sku
                     * Else create new sku
                     */
                    $skus = Productsku::where('product_id', $id)->where('size', $size->name)->where('color', $color->name)->first();



                    if (!empty($skus)) {
                        // if sku length is empty then fetch from default product fields
                        if (empty($skus->weight)) {
                            $skus->update([
                                'length' => $product->length,
                                'breath' => $product->breadth,
                                'height' => $product->height,
                                'weight' => $product->weight,
                            ]);
                        }

                        /**
                         * Dont create new sku
                         * Check if the sku is inactive then activate
                         */
                        $skus->update([
                            'status' => 1
                        ]);

                    } else {
                        /**
                         * Create new sku
                         */

                        $sku = new Productsku;
                        $sku->product_id = $id;
                        $sku->sku = $size->name . '-' . $color->name;
                        $sku->size = $size->name;
                        $sku->color = $color->name;
                        $sku->available_stock = Config::get('icrm.stock_management.default_stock');
                        $sku->status = '1';
                        $sku->length = $product->length;
                        $sku->breath = $product->breadth;
                        $sku->height = $product->height;
                        $sku->weight = $product->weight;
                        $sku->save();
                    }

                }
            } else {
                // do not add color as a sku field
                /**
                 * Check if the same sku is available or not
                 * If available then dont create new sku
                 * Else create new sku
                 */
                $skus = Productsku::where('product_id', $id)->where('size', $size->name)->get();

                if (count($skus) > 0) {
                    /**
                     * Dont create new sku
                     */
                } else {

                    /**
                     * Create new sku
                     */
                    $sku = new Productsku;
                    $sku->product_id = $id;
                    $sku->sku = $size->name;
                    $sku->size = $size->name;
                    $sku->available_stock = Config::get('icrm.stock_management.default_stock');
                    $sku->status = '1';
                    $sku->length = $product->length;
                    $sku->breath = $product->breadth;
                    $sku->height = $product->height;
                    $sku->weight = $product->weight;
                    $sku->save();
                }
            }
        }

        if (Config::get('icrm.product_sku.size') == 1) {
            /**
             * Inactive size sku if the size is not available in default field.
             */
            // dd($product->sizes->pluck('name'));
            $nonusesizeskus = Productsku::where('product_id', $id)->whereNotIn('size', $product->sizes->pluck('name'))->get();

            if (count($nonusesizeskus) > 0) {
                foreach ($nonusesizeskus as $nonusesizesku) {
                    $nonusesizesku->update([
                        'status' => '0'
                    ]);
                }
            }
        }

        if (Config::get('icrm.product_sku.color') == 1) {
            /**
             * Inactive color sku if the color is not available in default field.
             */

            $nonusecolorskus = Productsku::where('product_id', $id)->whereNotIn('color', $product->colors->pluck('name'))->get();

            if (count($nonusecolorskus) > 0) {
                foreach ($nonusecolorskus as $nonusecolorsku) {
                    $nonusecolorsku->update([
                        'status' => '0'
                    ]);
                }
            }
        }


        if (Config::get('icrm.product_sku.size') == 0 and Config::get('icrm.product_sku.color') == 0) {

            $skus = Productsku::where('product_id', $id)->first();

            // if sku length is empty then fetch from default product fields
            if (empty($skus->weight)) {
                $skus->update([
                    'length' => $product->length,
                    'breath' => $product->breadth,
                    'height' => $product->height,
                    'weight' => $product->weight,
                ]);
            }

            if (empty($skus)) {
                /**
                 * Create new sku
                 */
                $sku = new Productsku;
                $sku->product_id = $id;
                $sku->sku = $product->sku;
                $sku->size = 'NA';
                $sku->available_stock = Config::get('icrm.stock_management.default_stock');
                $sku->status = '1';
                $sku->length = $product->length;
                $sku->breath = $product->breadth;
                $sku->height = $product->height;
                $sku->weight = $product->weight;
                $sku->save();
            }


        }


        if (Config::get('icrm.product_sku.size') == 1 and Config::get('icrm.product_sku.color') == 0) {
            $skus = Productsku::where('product_id', $id)->first();

            // if sku length is empty then fetch from default product fields
            if (!empty($skus)) {
                if (empty($skus->weight)) {
                    $skus->update([
                        'length' => $product->length,
                        'breath' => $product->breadth,
                        'height' => $product->height,
                        'weight' => $product->weight,
                    ]);
                }
            }
        }

    }

    public function createcolors($id)
    {
        /**
         * Get product info
         * Create skus
         */

        $product = Product::where('id', $id)->with(['colors'])->first();

        foreach ($product->colors as $color) {
            $colorstatus = Productcolor::where('product_id', $id)->where('color', $color->name)->first();
            $colorname = $color->name;

            // if color already exists then dont add
            if (empty($colorstatus)) {
                $color = new Productcolor;
                $color->product_id = $id;
                $color->color = $colorname;
                // $color->main_image = $product->image;
                // $color->more_images = $product->images;
                $color->status = 1;
                $color->save();
            } else {
                $colorstatus->update([
                    'status' => 1
                ]);
            }

        }

        /**
         * Inactive color if the color is not available in default field.
         */

        $nonusecolors = Productcolor::where('product_id', $id)->whereNotIn('color', $product->colors->pluck('name'))->get();

        if (count($nonusecolors) > 0) {
            foreach ($nonusecolors as $nonusecolor) {
                $nonusecolor->update([
                    'status' => '0'
                ]);
            }
        }




    }

    public static function subcategoryIdRelationship($id)
    {

        return
            self::where('products.id', '=', $id)
                // select field from both the tables
                ->select('products.subcategory_id', 'product_categories.id as category_id')
                // join subcategory sizes to size table
                // ->join('product_subcategories', 'sizes.id', 'ps.size_id')
                // ->whereIn('sizes.id', 'product_subcategories.size_id')
                // join subcategory to product table
                ->join('product_subcategories', 'products.subcategory_id', '=', 'product_subcategories.id')
                // join category to subcategory table
                ->join('product_categories', 'product_subcategories.category_id', '=', 'product_categories.id')
                ->first();
    }



    public function productsku()
    {
        return $this->belongsTo(Productsku::class, 'id', 'product_id');
    }


    public function productskus()
    {
        return $this->hasMany(Productsku::class, 'product_id')->where('status', 1);

    }

    public function productcolors()
    {
        return $this->hasMany(Productcolor::class, 'product_id')->where('status', 1);
    }

    public function productreviews()
    {
        return $this->belongsTo(ProductReview::class, 'id', 'product_id')->where('status', 1);
    }


    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function vendor()
    {
        return $this->belongsTo(User::class, 'seller_id', 'id');
    }

    public function createdby()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function gender()
    {
        return $this->belongsTo(Gender::class, 'gender_id', 'id');
    }

    public function sizes()
    {
        return $this->belongsToMany(Size::class, 'size_product', 'product_id', 'size_id');
    }

    public function colors()
    {
        return $this->belongsToMany(Color::class, 'color_product', 'product_id', 'color_id');
    }

    public function productcategory()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    public function productsubcategory()
    {
        return $this->belongsTo(ProductSubcategory::class, 'subcategory_id');
    }

    public function trendingsubcategories()
    {
        return $this->belongsTo(ProductSubcategory::class, 'subcategory_id');
    }



}
