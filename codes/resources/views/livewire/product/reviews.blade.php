<div>
    <div class="row">
        <div class="col-lg-4 mb-6">
            <div class="avg-rating-container">
                @if (count($allreviews) > 0)
                    <mark>{{ $allreviews->sum('rate') / (count($allreviews) * 5) * 100 / 20 }}</mark>    
                @else
                    <mark>0</mark>
                @endif
                
                <div class="avg-rating">
                    <span class="avg-rating-title">Average Rating</span>
                    <div class="ratings-container mb-0">
                        <div class="ratings-full">
                            <span class="ratings" style="width: 
                            @if (count($allreviews) > 0)
                                {{ $allreviews->sum('rate') / (count($allreviews) * 5) * 100 }}%
                            @else
                                0
                            @endif
                            
                            "></span>
                            <span class="tooltiptext tooltip-top"></span>
                        </div>
                        <span class="rating-reviews">(
                            @if (count($allreviews) > 0)
                                {{ $this->product->productreviews()->count() }} 
                            @else
                                0
                            @endif
                            Reviews)</span>
                    </div>
                </div>
            </div>
            <div class="ratings-list mb-2">
                
                <div class="ratings-item">
                    <div class="ratings-container mb-0">
                        <div class="ratings-full">
                            <span class="ratings" style="width:100%"></span>
                            <span class="tooltiptext tooltip-top"></span>
                        </div>
                    </div>
                    <div class="rating-percent">
                        <span style="width:
                        @if (count($allreviews) > 0)
                            {{ $allreviews->where('rate', 5)->count() / count($allreviews) * 100 }}%;
                        @else
                            0%;
                        @endif
                        "></span>
                    </div>
                    <div class="progress-value">
                        @if (count($allreviews) > 0)
                            {{ number_format($allreviews->where('rate', 5)->count() / count($allreviews) * 100, 0) }}%
                        @else
                            0%
                        @endif
                    </div>
                </div>

                <div class="ratings-item">
                    <div class="ratings-container mb-0">
                        <div class="ratings-full">
                            <span class="ratings" style="width:80%"></span>
                            <span class="tooltiptext tooltip-top"></span>
                        </div>
                    </div>
                    <div class="rating-percent">
                        <span style="width:
                        @if (count($allreviews) > 0)
                            {{ $allreviews->where('rate', 4)->count() / count($allreviews) * 100 }}%;
                        @else
                            0%;
                        @endif
                        "></span>
                    </div>
                    <div class="progress-value">
                        @if (count($allreviews) > 0)
                            {{ number_format($allreviews->where('rate', 4)->count() / count($allreviews) * 100, 0) }}%
                        @else
                            0%
                        @endif
                    </div>
                </div>



                <div class="ratings-item">
                    <div class="ratings-container mb-0">
                        <div class="ratings-full">
                            <span class="ratings" style="width:60%"></span>
                            <span class="tooltiptext tooltip-top"></span>
                        </div>
                    </div>
                    <div class="rating-percent">
                        <span style="width:
                        @if (count($allreviews) > 0)
                            {{ $allreviews->where('rate', 3)->count() / count($allreviews) * 100 }}%;
                        @else
                            0%;
                        @endif
                        "></span>
                    </div>
                    <div class="progress-value">
                        @if (count($allreviews) > 0)
                            {{ number_format($allreviews->where('rate', 3)->count() / count($allreviews) * 100, 0) }}%
                        @else
                            0%
                        @endif
                    </div>
                </div>


                <div class="ratings-item">
                    <div class="ratings-container mb-0">
                        <div class="ratings-full">
                            <span class="ratings" style="width:40%"></span>
                            <span class="tooltiptext tooltip-top"></span>
                        </div>
                    </div>
                    <div class="rating-percent">
                        <span style="width:
                        @if (count($allreviews) > 0)
                            {{ $allreviews->where('rate', 2)->count() / count($allreviews) * 100 }}%;
                        @else
                            0%;
                        @endif
                        "></span>
                    </div>
                    <div class="progress-value">
                        @if (count($allreviews) > 0)
                            {{ number_format($allreviews->where('rate', 2)->count() / count($allreviews) * 100, 0) }}%
                        @else
                            0%
                        @endif
                    </div>
                </div>



                <div class="ratings-item">
                    <div class="ratings-container mb-0">
                        <div class="ratings-full">
                            <span class="ratings" style="width:20%"></span>
                            <span class="tooltiptext tooltip-top"></span>
                        </div>
                    </div>
                    <div class="rating-percent">
                        <span style="width:
                        @if (count($allreviews) > 0)
                            {{ $allreviews->where('rate', 1)->count() / count($allreviews) * 100 }}%;
                        @else
                            0%;
                        @endif
                        "></span>
                    </div>
                    <div class="progress-value">
                        @if (count($allreviews) > 0)
                            {{ number_format($allreviews->where('rate', 1)->count() / count($allreviews) * 100, 0) }}%
                        @else
                            0%
                        @endif
                    </div>
                </div>

            </div>
            
            @auth
                <a class="btn btn-dark btn-rounded submit-review-toggle" wire:click="openreviewmodal">Submit
                    Review</a>
            @else
                <a class="btn btn-dark btn-rounded submit-review-toggle" href="{{ route('login') }}">Submit
                    Review</a>
            @endauth
        </div>
        <div class="col-lg-8 comments pt-2 pb-10 border-no">

            <ul class="comments-list">
                @if (!empty($userreview))
                <li>
                    <div class="comment">
                        <div class="comment-body">
                            <div class="comment-rating ratings-container">
                                <div class="ratings-full">
                                    <span class="ratings" style="width:{{ $userreview->rate * 20 }}%"></span>
                                    <span class="tooltiptext tooltip-top"></span>
                                </div>
                            </div>
                            <div class="comment-user">
                                <span class="comment-date">by <span class="font-weight-semi-bold text-uppercase text-dark">{{ $userreview->user->name }}</span> on
                                    <span class="font-weight-semi-bold text-dark">{{ $userreview->created_at->diffForHumans() }}</span></span>
                            </div>
    
                            <div class="comment-content mb-5">
                                <p>{{ $userreview->comment }}</p>
                            </div>
                        </div>
                    </div>
                </li>
                @endif

                @isset($otherreviews)
                    @if (count($otherreviews) > 0)

                        @foreach ($otherreviews as $review)
                            <li>
                                <div class="comment">
                                    <div class="comment-body">
                                        <div class="comment-rating ratings-container">
                                            <div class="ratings-full">
                                                <span class="ratings" style="width:{{ $review->rate * 20 }}%"></span>
                                                <span class="tooltiptext tooltip-top"></span>
                                            </div>
                                        </div>
                                        <div class="comment-user">
                                            <span class="comment-date">by <span class="font-weight-semi-bold text-uppercase text-dark">{{ $review->user->name }}</span> on
                                                <span class="font-weight-semi-bold text-dark">{{ $review->created_at->diffForHumans() }}</span></span>
                                        </div>
                
                                        <div class="comment-content mb-5">
                                            <p>{{ $review->comment }}</p>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                        {!! $otherreviews->links() !!}
                    @endif
                @endisset
            </ul>
            {{-- <nav class="toolbox toolbox-pagination justify-content-end">
                <ul class="pagination">
                    <li class="page-item disabled">
                        <a class="page-link page-link-prev" href="#" aria-label="Previous" tabindex="-1" aria-disabled="true">
                            <i class="d-icon-arrow-left"></i>Prev
                        </a>
                    </li>
                    <li class="page-item active" aria-current="page"><a class="page-link" href="#">1</a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item page-item-dots"><a class="page-link" href="#">6</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link page-link-next" href="#" aria-label="Next">
                            Next<i class="d-icon-arrow-right"></i>
                        </a>
                    </li>
                </ul>
            </nav> --}}
        </div>
    </div>
    
    <div class="review-form-section @if($this->openreviewmodal == true) opened @endif">
        <div class="review-overlay" wire:click="closereviewmodal"></div>
        <div class="review-form-wrapper">
            <div class="title-wrapper text-left">
                <h3 class="title title-simple text-left text-normal">Add a Review</h3>
                <p>Your email address will not be published. Required fields are marked *
                </p>
            </div>
            <div class="rating-form">
                <label for="rating" class="text-dark">Your rating * </label>
                <span class="rating-stars selected">
                    <a class="star-1 @if($this->rate == 1) active @endif" wire:click="rating(1)">1</a>
                    <a class="star-2 @if($this->rate == 2) active @endif" wire:click="rating(2)">2</a>
                    <a class="star-3 @if($this->rate == 3) active @endif" wire:click="rating(3)">3</a>
                    <a class="star-4 @if($this->rate == 4) active @endif" wire:click="rating(4)">4</a>
                    <a class="star-5 @if($this->rate == 5) active @endif" wire:click="rating(5)">5</a>
                </span>
    
                <select name="rating" id="rating" required="" style="display: none;">
                    <option value="">Rate…</option>
                    <option value="5">Perfect</option>
                    <option value="4">Good</option>
                    <option value="3">Average</option>
                    <option value="2">Not that bad</option>
                    <option value="1">Very poor</option>
                </select>
            </div>
            <form wire:submit.prevent="reviewcomment">
                <textarea wire:model="comment" cols="30" rows="6" class="form-control mb-4" placeholder="Comment *" required=""></textarea>
                {{-- id="reply-message" --}}
    
                {{-- <div class="review-medias">
                    <div class="file-input form-control image-input" style="background-image: url({{ asset('images/product/placeholder.png') }});">
                        <div class="file-input-wrapper">
                        </div>
                        <label class="btn-action btn-upload" title="Upload Media">
                            <input type="file" accept=".png, .jpg, .jpeg" name="riode_comment_medias_image_1">
                        </label>
                        <label class="btn-action btn-remove" title="Remove Media">
                        </label>
                    </div>
                    <div class="file-input form-control image-input" style="background-image: url({{ asset('images/product/placeholder.png') }});">
                        <div class="file-input-wrapper">
                        </div>
                        <label class=" btn-action btn-upload" title="Upload Media">
                            <input type="file" accept=".png, .jpg, .jpeg" name="riode_comment_medias_image_2">
                        </label>
                        <label class="btn-action btn-remove" title="Remove Media">
                        </label>
                    </div>
                    <div class="file-input form-control video-input" style="background-image: url({{ asset('images/product/placeholder.png') }});">
                        <video class="file-input-wrapper" controls=""></video>
                        <label class="btn-action btn-upload" title="Upload Media">
                            <input type="file" accept=".avi, .mp4" name="riode_comment_medias_video_1">
                        </label>
                        <label class="btn-action btn-remove" title="Remove Media">
                        </label>
                    </div>
                </div>
                <p>Upload images and videos. Maximum count: 3, size: 2MB</p> --}}
                <button type="submit" class="btn btn-primary btn-rounded">Submit<i class="d-icon-arrow-right"></i></button>
            </form>
        </div>
    </div>    
</div>