<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use App\Models\Product\Product;
use App\Models\Product\Review;
use App\Models\Product\Cart;
use App\Models\Product\Order;
use App\Models\Product\Booking;
use Carbon\Carbon;
class ProductsController extends Controller
{
    /**
     * Display single product details with related products.
     */
public function home()
{
    $products = Product::orderBy('id', 'desc')->get();
    $reviews = Review::orderBy('id', 'desc')->take(5)->get(); // latest 5 reviews
    $orders = Order::with('product')->orderBy('id', 'desc')->get();
    return view('home', compact('products', 'reviews'));
}


    public function addCart(Request $request, $id)
{
    $request->validate([
        'pro_id' => 'required|exists:products,id',
        'name' => 'required|string',
        'image' => 'required|string',
        'price' => 'required|numeric',
    ]);

    // Determine logged-in user id for both guards
    $userId = null;
    if (Auth::guard('web')->check()) {
        $userId = Auth::guard('web')->id();
    } elseif (Auth::guard('admin')->check()) {
        $userId = Auth::guard('admin')->id();
    }

    // If still null, you may allow nullable, but better check
    if (!$userId) {
        return redirect()->back()->with('error', 'You must be logged in to add to cart.');
    }

    Cart::create([
        'pro_id' => $request->pro_id,
        'name' => $request->name,
        'image' => $request->image,
        'price' => $request->price,
        'user_id' => $userId,
    ]);

    return redirect()->route('product.single', $id)
                     ->with(['success' => "Product added to cart successfully"]);
}

public function singleProduct($id)
{
    $product = Product::findOrFail($id);

    $relatedProducts = Product::where('type', $product->type)
                               ->where('id', '!=', $id)
                               ->orderBy('id', 'desc')
                               ->take(4)
                               ->get();

    // Check if product is in the current user's cart
    $checkInCart = 0;
    if (Auth::check()) { // for logged-in user
        $checkInCart = Cart::where('user_id', Auth::id())
                           ->where('pro_id', $product->id)
                           ->count();
    }

    return view('products.product-single', compact('product', 'relatedProducts', 'checkInCart'));
}

    /**
     * Display user's cart.
     */
    public function cart()
    {
        if (!Auth::check()) {
            return Redirect::route('login')->with(['error' => "You need to login first"]);
        }

        $cart = Cart::where('user_id', Auth::id())->orderBy('id', 'desc')->get();
        $totalPrice = $cart->sum(fn($item) => floatval($item->price));

        return view('products.cart', compact('cart', 'totalPrice'));
    }

    /**
     * Delete product from cart.
     */
    public function deleteProductCart($id)
    {
        $item = Cart::where('pro_id', $id)->where('user_id', Auth::id())->first();

        if ($item) {
            $item->delete();
            return Redirect::route('cart')->with(['delete' => "Product deleted from cart successfully"]);
        }

        return Redirect::route('cart')->with(['error' => "Product not found in cart"]);
    }

    /**
     * Prepare checkout by saving total price in session.
     */
   public function prepareCheckout(Request $request)
{
    $request->validate([
        'price' => 'required|numeric|min:0'
    ]);

    Session::put('price', $request->price);

    return redirect()->route('products.paypal');
}



    /**
     * Display checkout page.
     */
    public function checkout()
    {
        return view('products.checkout');
    }

    /**
     * Store checkout and create order.
     */
    public function storeCheckout(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'address' => 'required|string',
            'city' => 'required|string',
            'zip_code' => 'nullable|string',
            'phone' => 'required|string',
            'email' => 'required|email',
            'price' => 'required|numeric',
        ]);

     $order = Order::create([
    'first_name' => $request->first_name,
    'last_name' => $request->last_name,
    'address' => $request->address,
    'city' => $request->city,
    'zip_code' => $request->zip_code,
    'phone' => $request->phone,
    'email' => $request->email,
    'price' => $request->price,
    'user_id' => Auth::id(),
    'product_id' => $request->product_id, // <-- make sure you pass this
    'status' => 'Pending',
]);

        return Redirect::route('products.paypal')->with(['order_id' => $order->id]);
    }

   public function paywithpaypal()
{
    $price = session('price', 0);
    if ($price <= 0) {
        return redirect()->route('cart')->with('error', 'Cart is empty or invalid total');
    }

    return view('products.paypal', compact('price'));
}

public function success(Request $request)
{
    // Clear cart and session
    if(Auth::check()) {
        Cart::where('user_id', Auth::id())->delete();
    }
    Session::forget('price');

    return view('products.success');
}



    /**
     * Booking tables.
     */
 public function BookingTables(Request $request)
{
    // 1️⃣ Validate form input
    $request->validate([
        'first_name' => 'required|max:40',
        'last_name'  => 'required|max:40',
        'date'       => 'required|date|after:today',
        'time'       => 'required',
        'phone'      => 'required|max:40',
        'message'    => 'nullable',
    ]);

    // 2️⃣ Convert date and time to MySQL format
    try {
        $date = Carbon::createFromFormat('m/d/Y', $request->date)->format('Y-m-d');
        $time = Carbon::parse($request->time)->format('H:i:s');
    } catch (\Exception $e) {
        return redirect()->route('home')->with('error', 'Invalid date or time format.');
    }

    // 3️⃣ Create the booking
    $booking = Booking::create([
        'user_id'    => Auth::id(),
        'first_name' => $request->first_name,
        'last_name'  => $request->last_name,
        'date'       => $date,
        'time'       => $time,
        'phone'      => $request->phone,
        'message'    => $request->message,
        'status'     => 'Pending',
    ]);

    // 4️⃣ Stay on home with success/error message
    return redirect()->route('home')
                     ->with($booking ? 'success' : 'error', $booking ? 'You booked a table successfully!' : 'Failed to book a table.');
}


    /**
     * Static pages and menu.
     */    public function contact() { return view('products.contact'); }
    public function service() { return view('pages.service'); }
    public function about() { return view('products.about'); }

    public function menu()
    {
        $desserts = Product::where("type", "desserts")->orderBy('id', 'desc')->take(4)->get();
        $drinks = Product::where("type", "drinks")->orderBy('id', 'desc')->take(4)->get();
        return view('products.menu', compact('desserts', 'drinks'));
    }
}
