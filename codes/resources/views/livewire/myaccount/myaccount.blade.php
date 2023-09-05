<div>
    <main class="main account">
        <nav class="breadcrumb-nav">
            <div class="container">
                <ul class="breadcrumb">
                    <li><a href="{{ route('welcome') }}"><i class="d-icon-home"></i></a></li>
                    <li>Account</li>
                </ul>
            </div>
        </nav>
        <div class="page-content mt-4 mb-10 pb-6">
            <div class="container">
                <h2 class="title title-center mb-10">Welcome {{ auth()->user()->name }}</h2>
                <div class="tab tab-vertical gutter-lg">
                    <ul class="nav nav-tabs mb-4 col-lg-3 col-md-4" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" href="#account">Account details</a>
                        </li>

                        {{-- <li class="nav-item">
                            <a class="nav-link" href="#password-change">Password Change</a>
                        </li> --}}
                        
                        <li class="nav-item">
                            <a class="nav-link" href="#address">Address</a>
                        </li>
    
                        <li class="nav-item">
                            <a class="nav-links" href="{{ route('myorders') }}" style="font-size: 1.6rem;">My Orders</a>
                        </li>

                        @if (Config::get('icrm.showcase_at_home.feature') == 1)
                            <li class="nav-item">
                                <a class="nav-links" href="{{ route('showcase.myorders') }}" style="font-size: 1.6rem;">Showcase Orders</a>
                            </li>
                        @endif
    
                        <li class="nav-item">
                            <a  class="nav-link" href="#" onclick="event.preventDefault();document.getElementById('logout-form').submit();" style="color: red;"> Logout </a>
    
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                            </form>
                        </li>
                    </ul>
                    <div class="tab-content col-lg-9 col-md-8">
                        <div class="tab-pane active in" id="account">
                            
                            <div class="alert alert-message alert-light alert-primary alert-link mb-10">
                                <h4 class="alert-title">Message</h4>
                                <p>Keep your account information updated!</p>
                                <button type="button" class="btn btn-link btn-close">
                                    <i class="d-icon-times"></i>
                                </button>
                            </div>
    
                            <form wire:submit.prevent="updateAccount" method="post" class="form">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label>Name *</label>
                                        <input type="text" class="form-control" wire:model="name" required="" autofocus >
                                        @error('name') <span class="error">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="col-sm-6">
                                        <label>Gender *</label>
                                        <select class="form-control" wire:model="gender">
                                            <option value="">Select Gender</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                            <option value="Other">Other</option>
                                        </select>
                                        @error('gender') <span class="error">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <label>Email *</label>
                                        <input type="email" class="form-control disabled" wire:model="email" required disabled readonly>
                                        @error('email') <span class="error">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-sm-6">
                                        <label>Register Mobile Number *</label>
                                        <input type="text" class="form-control" wire:model="mobile" required="">
                                        @error('mobile') <span class="error">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                
                                @if (Config::get('icrm.auth.fields.companyinfo') == true)
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label>Company Name *</label>
                                            <input type="text" class="form-control" wire:model="company_name" required @if(!empty(auth()->user()->company_name)) readonly @endif>
                                            @error('company_name') <span class="error">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="col-sm-6">
                                            <label>GST Number *</label>
                                            <input type="text" class="form-control" wire:model="gst_number" @if(!empty(auth()->user()->gst_number)) readonly @endif>
                                            @error('gst_number') <span class="error">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                @endif
                                
                                <button type="submit" class="btn btn-primary">SAVE CHANGES</button>
                            </form>
                        </div>


                        <div class="tab-pane" id="password-change">
                            
                            <div class="alert alert-message alert-light alert-primary alert-link mb-10">
                                <h4 class="alert-title">Message</h4>
                                <p>Change your account password!</p>
                                <button type="button" class="btn btn-link btn-close">
                                    <i class="d-icon-times"></i>
                                </button>
                            </div>
    
                            <form action="#" class="form">
                                <fieldset>
                                    <legend>Password Change</legend>
                                    <label>Current password (leave blank to leave unchanged)</label>
                                    <input type="password" class="form-control" name="current_password">
    
                                    <label>New password (leave blank to leave unchanged)</label>
                                    <input type="password" class="form-control" name="new_password">
    
                                    <label>Confirm new password</label>
                                    <input type="password" class="form-control" name="confirm_password">
                                </fieldset>
    
                                <button type="submit" class="btn btn-primary">SAVE CHANGES</button>
                            </form>
                        </div>

                        <div class="tab-pane" id="address">
                            
                            <div class="alert alert-message alert-light alert-primary alert-link mb-10">
                                <h4 class="alert-title">Message</h4>
                                <p>You can mention your delivery address here for quick checkout!</p>
                                <button type="button" class="btn btn-link btn-close">
                                    <i class="d-icon-times"></i>
                                </button>
                            </div>
    
                            <form wire:submit.prevent="updateAddress" method="post" class="form">
                                @csrf
                                

                                <div class="row">
                                    <div class="col-sm-6">
                                        <label>Street Address 1 *</label>
                                        <textarea class="form-control" wire:model.defer="street_address_1" required="" autofocus></textarea>
                                    </div>

                                    <div class="col-sm-6">
                                        <label>Street Address 2 *</label>
                                        <textarea class="form-control" wire:model.defer="street_address_2" required=""></textarea>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <label>Pincode *</label>
                                        <input type="text" class="form-control" wire:model.defer="pincode" required="">
                                    </div>
                                    <div class="col-sm-6">
                                        <label>City *</label>
                                        <input type="text" class="form-control" wire:model.defer="city" required="">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <label>State *</label>
                                        <input type="text" class="form-control" wire:model.defer="state" required="">
                                    </div>
                                    <div class="col-sm-6">
                                        <label>Country *</label>
                                        <select class="form-control" wire:model.defer="country" required="">
                                            <option value="">Select Country</option>
                                            <option value="India">India</option>
                                        </select>
                                    </div>
                                </div>
    
                                
                                <button type="submit" class="btn btn-primary">SAVE CHANGES</button>
                            </form>
                        </div>



                    </div>
                </div>
            </div>
        </div>
    </main>
</div>


