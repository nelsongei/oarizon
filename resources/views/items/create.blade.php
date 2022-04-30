@extends('layouts.main_hr')
@section('xara_cbs')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <!-- [ page content ] start -->
                    <div class="card">
                        <div class="card-header">
                            <h3>New Item</h3>

                            @if (Session::has('flash_message'))

                                <div class="alert alert-success">
                                    {{ Session::get('flash_message') }}
                                </div>
                            @endif

                            @if (Session::has('delete_message'))

                                <div class="alert alert-danger">
                                    {{ Session::get('delete_message') }}
                                </div>
                            @endif

                        </div>
                        <div class="card-block">
                          <div class="col-lg-5">
                            @if ($errors->count())
                               <div class="alert alert-danger">
                                   @foreach ($errors->all() as $error)
                                       {{ $error }}<br>
                                   @endforeach
                               </div>
                               @endif

                            <form method="POST" action="{{{ URL::to('items') }}}" accept-charset="UTF-8">
                                @csrf
                           <fieldset>
                               <div class="form-group">
                                   <label for="username">Item Name <span style="color:red">*</span> :</label>
                                   <input class="form-control" placeholder="" type="text" name="name" id="name" value="{{{ Request::old('name') }}}" required>
                               </div>

                               <div class="form-group">
                                   <label for="username">Item Category <span style="color:red">*</span> :</label><br>
                                   <select name="category" class="form-control" required>
                                   @foreach ($category as $category)
                                   <option value="{{$category->id}}">{{$category->name}}</option>
                                   @endforeach
                                   </select>
                               </div>

                                <div class="form-group">
                                   <label for="username">Description:</label>
                                   <textarea rows="5" class="form-control" name="description" id="description" >{{ Request::old('email_office') }}</textarea>
                               </div>

                               <div class="radio">
                                 <label>
                                     <input type="radio" name="type" id="product" value="product">
                                           Product
                                     </label>
                                     <br>
                                     <p>

                               </div>

                               <div class="radio">
                                 <label>
                                     <input type="radio" name="type" id="service" value="service">
                                           Service
                                     </label>
                                     <br>
                                     <p>

                               </div>


                               <div class="form-group" id="purchase_price">
                               <div class="form-group">
                                   <label for="username">Purchase Price:</label>
                                   <input class="form-control" placeholder="" type="text" name="pprice" id="pprice" value="{{{ Request::old('pprice') }}}">
                               </div>
                               </div>

                               <div class="form-group" id="selling_price">
                               <div class="form-group">
                                   <label for="username">Selling price <span style="color:red">*</span> :</label>
                                   <input class="form-control" placeholder="" type="text" name="sprice" id="sprice" value="{{{ Request::old('sprice') }}}" required>
                               </div>
                               </div>


                                <script type="text/javascript">
                                   $(document).ready(function(){
                                   /*$("#purchase_price").hide();*/
                                   $('#product').click(function(){

                                   if($('#product').is(":checked")){
                                   $('#product:checked').each(function(){

                                   $("#purchase_price").show();

                                   $("#selling_price").show();

                                   $("#reorderlevel").show();

                                   $("#store_unit").show();

                                   });
                                   }else{

                                     $("#purchase_price").hide();

                                     $("#selling_price").hide();
                                   }
                                   });




                                   $('#service').click(function(){

                                   if($('#service').is(":checked")){
                                   $('#service:checked').each(function(){
                                   $("#purchase_price").hide();
                                   $("#selling_price").show();
                                   $("#reorderlevel").hide();
                                   $("#store_unit").hide();

                                   });
                                   }else{

                                     $("#selling_price").hide();
                                     $("#reorderlevel").show();
                                     $("#store_unit").show();
                                   }
                                   });

                                   });
                                 </script>

                               <!-- <div class="form-group" id="store_unit">
                               <div class="form-group">
                                   <label for="username">Store Keeping Unit:</label>
                                   <input class="form-control" placeholder="" type="text" name="sku" id="sku" value="">
                               </div>
                               </div>

                               <div class="form-group">
                                   <label for="username">Tag Id:</label>
                                   <input class="form-control" placeholder="" type="text" name="tag" id="tag" value="">
                               </div> -->

                               <div class="form-group" id="reorderlevel">
                               <div class="form-group">
                                   <label for="username">Reorder Level:</label>
                                   <input class="form-control" placeholder="" type="text" name="reorder" id="reorder" value="{{{ Request::old('reorder') }}}">
                               </div>
                               </div>

                               <div class="form-actions form-group">

                                 <button type="submit" class="btn btn-primary btn-sm">Create Item</button>
                               </div>

                           </fieldset>
                       </form>


                         </div>

                        </div>
                    </div>
                    <!-- [ page content ] end -->
                </div>
            </div>
        </div>
    </div>
@stop
