<div>
    <button class="btn btn-sm outofstock" wire:click="showreturnmodel">Returns</button>

    <div class="review-form-section @if ($this->openmodel == true) opened @endif">
        <div class="review-overlay" wire:click="closereturnmodel"></div>
        <div class="review-form-wrapper">
            <div class="title-wrapper text-left">
                <h3 class="title title-simple text-left text-normal">RETURNS</h3>
                <p>
                    @if (Config::get('icrm.order_lifecycle.return.exchange') == 1)
                        Exchange product
                    @endif

                    @if (Config::get('icrm.order_lifecycle.return.exchange') == 1 and Config::get('icrm.order_lifecycle.return.refund') == 1)
                        or
                    @endif

                    @if (Config::get('icrm.order_lifecycle.return.refund') == 1)
                        Request a refund.
                    @endif
                </p>
            </div>
            <form wire:submit.prevent="requestreturn">
                <div class="rating-form">
                    <div class="questions">
                        <div class="question product-details">
                            <label for="">Product Details</label>
                            <div class="product">
                                <div class="image">
                                    <img src="{{ Voyager::image($this->item->product->image) }}"
                                        alt="{{ $this->item->product->name }}">
                                </div>
                                <div class="info">
                                    <div class="name">
                                        <p>{{ $this->item->product->name }}</p>
                                    </div>
                                    <div class="varients">
                                        <div class="varient">
                                            <p>Size</p>
                                            <p>{{ $this->item->size }}</p>
                                        </div>
                                        <div class="varient">
                                            <p>Color</p>
                                            <p>{{ $this->item->color }}</p>
                                        </div>
                                        @if (!empty($this->item->g_plus))
                                            <div class="varient">
                                                <p>G+</p>
                                                <p>{{ $this->item->g_plus }}</p>
                                            </div>
                                        @endif
                                        @if (!empty($this->item->requirement_document))
                                            <div class="varient">
                                                <p>Requirement Document</p>
                                                <p>{{ $this->item->requirement_document }}</p>
                                            </div>
                                        @endif

                                        <div class="varient">
                                            <p>Qty</p>
                                            <p>{{ $this->item->qty }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="question">
                            <label for="">What do you want?</label>
                            @if (Config::get('icrm.order_lifecycle.return.exchange') == 1)
                                <input type="radio" wire:model="return_type" value="Exchange"> Exchange
                            @endif
                            @if (Config::get('icrm.order_lifecycle.return.refund') == 1)
                                <input type="radio" wire:model="return_type" value="Refund"> Refund
                            @endif
                        </div>

                        <div class="question">
                            <label for="">Reason of return</label>
                            <select wire:model="return_reason" required>
                                <option value="">Select reason of return</option>
                                <option value="Wrong product received">Wrong product received</option>
                                <option value="Size fit issue">Size fit issue</option>
                                <option value="Package Hampered">Package Hampered</option>
                                <option value="Used Product sent">Used Product sent</option>
                                <option value="Late delivery">Late delivery</option>
                                <option value="Incorrect depiction in images.">Incorrect depiction in images.</option>
                                <option value="Defective product">Defective product</option>
                            </select>
                        </div>

                        <div class="question">
                            <textarea wire:model="return_comment" cols="30" rows="2" class="form-control mb-4" placeholder="Tell us more"
                                required></textarea>
                        </div>

                        <div class="question">
                            <input type="checkbox" required> I agree to return the items back in original condition.
                        </div>
                    </div>
                </div>
                <a wire:click="closereturnmodel" class="btn btn-default btn-rounded"><i class="d-icon-arrow-left"></i>
                    Cancel</a>
                <button type="submit" class="btn btn-primary btn-rounded">Submit<i
                        class="d-icon-arrow-right"></i></button>
            </form>
        </div>
    </div>

</div>
