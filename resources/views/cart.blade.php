<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Shopping Cart</title>
    <link rel="stylesheet" href="{{asset('assets/')}}/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{asset('assets/')}}/css/style.css">
<body>
    <div class="card">
        <div class="row">
            <div class="col-md-8 cart">
                <div class="title">
                    <div class="row">
                        <div class="col"><h4><b>Shopping Cart</b></h4></div>
                        <div class="col align-self-center text-right text-muted ">
                            <span class="qtyTotal">{{$totalQuantity}}</span>
                             items
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <label class="input-group-text" for="inputGroupSelect01">Products</label>
                    </div>
                    <select class="custom-select" id="inputGroupSelect01">
                      <option selected disabled>Choose...</option>
                      @foreach ($products as $product)
                        @php
                            $disabled = $cartItems->contains('product_id', $product->id) ? 'disabled' : '';
                        @endphp
                      <option {{$disabled}} product_name="{{$product->name}}" stock="{{$product->stock}}" price="{{$product->price}}" value="{{$product->id}}">{{$product->name}}</option>
                     @endforeach

                    </select>
                </div>
                <div>
                    <table class="table table-hover">
                        <thead>
                          <tr>

                            <th class="text-center">Product Name</th>
                            <th class="text-center">Price</th>
                            <th class="text-center">Quantity</th>
                            <th class="text-center">Delete</th>
                          </tr>
                        </thead>
                        <tbody id="tableBody">


                            @foreach ($cartItems as $cartItem)
                            <tr>
                                <td class="text-center"><div><p style="line-height: 3;" product_id={{$cartItem->product_id}}>{{$cartItem->product->name}}</p></div></td>
                                <td class="text-center"><div><p style="line-height: 3;" product_id='{{$cartItem->product_id}}'>{{$cartItem->product->price}}</p></div></td>

                                <td class="text-center">
                                    <div class="quantity text-center">
                                        <div class="pro-qty text-center">
                                            <span class="dec qtybtn up">-</span>
                                            <input type="number" value="{{$cartItem->qty}}" max="{{$cartItem->product->stock}}" onkeydown="return false" product_id={{$cartItem->product_id}} >
                                            <span class="inc qtybtn up">+</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center remove-row" style="line-height: 3; cursor: pointer;" product_id='{{$cartItem->product_id}}' product_name="{{$cartItem->product->name}}">✕</td>
                            </tr>
                            @endforeach



                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-4 summary">
                <div class="row">
                    <div><h5><b>Summary</b></h5> </div>
                    <div class="col text-right ">
                        @if(auth()->check())
                        <form method="POST" action="{{route('logout')}}">
                            @csrf
                            <button type="submit">Logout</button>
                        </form>
                    @else
                    @endif
                    </div>
                </div>


                <hr>
                <div class="row">
                    <div class="col" style="padding-left:0;">ITEMS <span class="qtyTotal">{{$totalQuantity}}</span></div>

                </div>
                <div class="row">
                    <div class="col "style="padding-left:0;">Subtotal :</div>
                    <div class="col text-right subtotal">$ {{$total['subtotal']}}</div>
                </div>
                <div class="row">
                    <div class="col "style="padding-left:0;">Shipping :</div>
                    <div class="col text-right shipping">$ {{$total['shipping'] }}</div>
                </div>
                <div class="row">
                    <div class="col "style="padding-left:0;">Vet :</div>
                    <div class="col text-right vat">$ {{$total['vat']}}</div>
                </div>
                <div class="row">
                    <div class="col "style="padding-left:0;">Discounts :</div>

                </div>
                <div id="discounts">
                    @foreach ($total['discounts'] as $key => $value)
                        @if ($key != 'total')
                            <div class="row">
                                <div class="col ">{{ $key }}</div>
                                <div class="col text-right">- ${{ $value }}</div>
                            </div>
                        @endif
                    @endforeach
                </div>
                <div class="row" style="border-top: 1px solid rgba(0,0,0,.1); padding: 2vh 0;">
                    <div class="col">TOTAL PRICE</div>
                    <div class="col text-right total">$ {{$total['total']}}</div>
                </div>

            </div>
        </div>

    </div>

   <script src="{{asset('assets/')}}/js/jquery-3.6.0.min.js"></script>
   <script src="{{asset('assets/')}}/js/popper.min.js"></script>
   <script src="{{asset('assets/')}}/js/bootstrap.min.js"></script>
   <script src="{{asset('assets/')}}/js/main.js"></script>
</body>
</html>
