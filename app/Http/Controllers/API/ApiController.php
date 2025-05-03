<?php

namespace App\Http\Controllers\API;

use App\helpers\GlobalFunction;
use App\Models\Grade;
use App\Models\Compus;
use App\Models\Onboard;
use App\Models\Student;
use App\Models\Department;
use App\Models\Recruitment;
use Illuminate\Http\Request;
use App\Models\CourseCategory;
use App\Http\Controllers\Controller;
use App\Models\Baner;
use App\Models\Brand;
use App\Models\News;
use App\Models\BusinessSetting;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\Promotion;
use App\Models\ShoesSlider;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{
    public function getBrand(Request $request)
    {
        $brands = Brand::where('status', '1')
                    ->select('id', 'name', 'image', 'status')
                    ->paginate(10);

        $brands->getCollection()->transform(function ($brand) {
            $brand->image = asset('uploads/brand/' . $brand->image);
            return $brand;
        });

        if ($brands->isEmpty()) {
            return response()->json(['message' => 'No records found'], 404);
        }

        return response()->json($brands, 200);
    }

    public function getBrandDetail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:brands,id'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $id = $request->input('id');
        $brand = Brand::where('id', $id)
            ->select('id', 'name', 'image', 'status')
            ->where('status', 1)
            ->first();

        if (!$brand) {
            return response()->json(['error' => 'Brand not found'], 404);
        }

        $brand->image = asset('uploads/brand/' . $brand->image);

        return response()->json($brand, 200);
    }

    public function getBannerSlider()
    {
        $baner_slider = Baner::where('status', 1)
                        ->select('id', 'name', 'image', 'status')
                        ->get();
        $baner_slider = $baner_slider->map(function ($baner) {
            $baner->image = asset('uploads/banner-slider/' . $baner->image);
            return $baner;
        });

        if ($baner_slider->isEmpty()) {
            return response()->json(['message' => 'No Record Found'], 200);
        }

        return response()->json($baner_slider, 200);
    }

    public function getConfig(Request $request)
    {
        $configs = BusinessSetting::all();
        $data = [];

        foreach ($configs as $config) {
            $data[$config->type] = $config->value;

            if (in_array($config->type, ['language', 'pnc_language'])) {
                $data[$config->type] = json_decode($config->value, true);
            }

            if (in_array($config->type, ['web_header_logo', 'web_banner_logo', 'fav_icon'])) {
                if ($config->value && file_exists('uploads/business_settings/' . $config->value)) {
                    $data[$config->type] = asset('uploads/business_settings/' . $config->value);
                } else {
                    $data[$config->type] = asset('uploads/image/default.png');
                }
            }
        }

        return response()->json($data, 200, [], JSON_PRETTY_PRINT);
    }

    public function getShoesSlider()
    {
        $shoes_slider = ShoesSlider::where('status', 1)
                    ->select('id', 'title', 'image', 'status')
                    ->get();

        $shoes_slider = $shoes_slider->map(function ($shoes) {
            $shoes->image = asset('uploads/shoes-slider/' . $shoes->image);
            return $shoes;
        });

        if ($shoes_slider->isEmpty()) {
            return response()->json(['message' => 'No Record Found'], 200);
        }

        return response()->json($shoes_slider, 200);
    }

    public function getProduct(Request $request)
    {
        $query = Product::where('status', '1')
            ->with(['productgallery' => function ($query) {
                $query->select('id', 'product_id', 'images');
            }])
            ->select('id', 'name', 'brand_id', 'rating', 'product_info');

        $products = $query->paginate(10);

        $products->getCollection()->transform(function ($product) {
            $firstProductInfo = $product->product_info[0] ?? null;

            if ($firstProductInfo) {
                $product->price = $firstProductInfo['product_price'] ?? null;
                $product->product_info = [$firstProductInfo];
            } else {
                $product->price = null;
                $product->product_info = [];
            }

            if ($product->productgallery && is_array($product->productgallery->images)) {
                $firstImage = $product->productgallery->images[0] ?? null;
                $product->image = $firstImage
                    ? asset('uploads/products/' . $firstImage)
                    : null;
            } else {
                $product->image = null;
            }

            unset($product->productgallery);

            return $product;
        });

        if ($products->isEmpty()) {
            return response()->json(['message' => 'No records found'], 404);
        }

        return response()->json($products, 200);
    }

    public function getProductNewArrival(Request $request)
    {
        $query = Product::where('status', '1')
            ->where('new_arrival', '1')
            ->with(['productgallery' => function ($query) {
                $query->select('id', 'product_id', 'images');
            }])
            ->select('id', 'name', 'brand_id', 'rating', 'product_info');

        $products = $query->paginate(10);

        $products->getCollection()->transform(function ($product) {
            $firstProductInfo = $product->product_info[0] ?? null;

            if ($firstProductInfo) {
                $product->price = $firstProductInfo['product_price'] ?? null;
                $product->product_info = [$firstProductInfo];
            } else {
                $product->price = null;
                $product->product_info = [];
            }

            if ($product->productgallery && is_array($product->productgallery->images)) {
                $firstImage = $product->productgallery->images[0] ?? null;
                $product->image = $firstImage
                    ? asset('uploads/products/' . $firstImage)
                    : null;
            } else {
                $product->image = null;
            }

            unset($product->productgallery);

            return $product;
        });

        if ($products->isEmpty()) {
            return response()->json(['message' => 'No records found'], 404);
        }

        return response()->json($products, 200);
    }

    public function getProductRecommended(Request $request)
    {
        $query = Product::where('status', '1')
            ->where('recommended', '1')
            ->with(['productgallery' => function ($query) {
                $query->select('id', 'product_id', 'images');
            }])
            ->select('id', 'name', 'brand_id', 'rating', 'product_info');

        $products = $query->paginate(10);

        $products->getCollection()->transform(function ($product) {
            $firstProductInfo = $product->product_info[0] ?? null;

            if ($firstProductInfo) {
                $product->price = $firstProductInfo['product_price'] ?? null;
                $product->product_info = [$firstProductInfo];
            } else {
                $product->price = null;
                $product->product_info = [];
            }

            if ($product->productgallery && is_array($product->productgallery->images)) {
                $firstImage = $product->productgallery->images[0] ?? null;
                $product->image = $firstImage
                    ? asset('uploads/products/' . $firstImage)
                    : null;
            } else {
                $product->image = null;
            }

            unset($product->productgallery);

            return $product;
        });

        if ($products->isEmpty()) {
            return response()->json(['message' => 'No records found'], 404);
        }

        return response()->json($products, 200);
    }

    public function getProductPopular(Request $request)
    {
        $query = Product::where('status', '1')
            ->where('popular', '1')
            ->with(['productgallery' => function ($query) {
                $query->select('id', 'product_id', 'images');
            }])
            ->select('id', 'name', 'brand_id', 'rating', 'product_info');

        $products = $query->paginate(10);

        $products->getCollection()->transform(function ($product) {
            $firstProductInfo = $product->product_info[0] ?? null;

            if ($firstProductInfo) {
                $product->price = $firstProductInfo['product_price'] ?? null;
                $product->product_info = [$firstProductInfo];
            } else {
                $product->price = null;
                $product->product_info = [];
            }

            if ($product->productgallery && is_array($product->productgallery->images)) {
                $firstImage = $product->productgallery->images[0] ?? null;
                $product->image = $firstImage
                    ? asset('uploads/products/' . $firstImage)
                    : null;
            } else {
                $product->image = null;
            }

            unset($product->productgallery);

            return $product;
        });

        if ($products->isEmpty()) {
            return response()->json(['message' => 'No records found'], 404);
        }

        return response()->json($products, 200);
    }

    public function searchProduct(Request $request)
    {
        $searchTerm = $request->input('name', '');

        $query = Product::where('status', '1')
            ->when($searchTerm, function ($query, $searchTerm) {
                return $query->where('name', 'LIKE', '%' . $searchTerm . '%');
            })
            ->with(['productgallery' => function ($query) {
                $query->select('id', 'product_id', 'images');
            }])
            ->select('id', 'name', 'brand_id', 'rating', 'product_info');

        $products = $query->paginate(10);

        $products->getCollection()->transform(function ($product) {
            $firstProductInfo = $product->product_info[0] ?? null;

            if ($firstProductInfo) {
                $product->price = $firstProductInfo['product_price'] ?? null;
                $product->product_info = [$firstProductInfo];
            } else {
                $product->price = null;
                $product->product_info = [];
            }

            if ($product->productgallery && is_array($product->productgallery->images)) {
                $firstImage = $product->productgallery->images[0] ?? null;
                $product->image = $firstImage
                    ? asset('uploads/products/' . $firstImage)
                    : null;
            } else {
                $product->image = null;
            }

            unset($product->productgallery);

            return $product;
        });

        if ($products->isEmpty()) {
            return response()->json(['message' => 'No records found'], 404);
        }

        return response()->json($products, 200);
    }

    public function getProductByBrand(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'brand_id' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $query = Product::where('status', '1')
            ->where('brand_id', $request->input('brand_id'))
            ->with(['productgallery' => function ($query) {
                $query->select('id', 'product_id', 'images');
            }])
            ->select('id', 'name', 'brand_id', 'rating', 'product_info');

        $products = $query->paginate(10);

        $products->getCollection()->transform(function ($product) {
            $firstProductInfo = $product->product_info[0] ?? null;

            if ($firstProductInfo) {
                $product->price = $firstProductInfo['product_price'] ?? null;
                $product->product_info = [$firstProductInfo];
            } else {
                $product->price = null;
                $product->product_info = [];
            }

            if ($product->productgallery && is_array($product->productgallery->images)) {
                $firstImage = $product->productgallery->images[0] ?? null;
                $product->image = $firstImage
                    ? asset('uploads/products/' . $firstImage)
                    : null;
            } else {
                $product->image = null;
            }

            unset($product->productgallery);

            return $product;
        });

        if ($products->isEmpty()) {
            return response()->json(['message' => 'No records found'], 404);
        }

        return response()->json($products, 200);
    }

    public function getProductDetail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $product = Product::where('id', $request->input('id'))
            ->where('status', 1)
            ->with([
                'productgallery' => function ($query) {
                    $query->select('id', 'product_id', 'images');
                }
            ])
            ->first();

        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        $images = $product->productgallery->images ?? [];
        $product->images = !empty($images)
            ? array_map(function ($image) {
                return asset('uploads/products/' . $image);
            }, $images)
            : [];

        $product->image = !empty($product->images) ? $product->images[0] : null;

        $productInfo = is_string($product->product_info)
            ? json_decode($product->product_info, true)
            : (is_array($product->product_info) ? $product->product_info : []);

        $product->product_info = $productInfo;

        $product->price = !empty($productInfo) && isset($productInfo[0]['product_price'])
            ? $productInfo[0]['product_price']
            : null;

        unset($product->productgallery);
        unset($product->created_by, $product->deleted_at, $product->created_at, $product->updated_at);

        return response()->json($product, 200);
    }

    public function getPromotion(Request $request)
    {
        $currentDate = Carbon::now();

        $promotions = Promotion::where('status', '1')
            ->with('activeProducts.productgallery', 'activeBrands')
            ->with(['promotiongallery' => function($query) {
                $query->select('id', 'promotion_id', 'images');
            }])
            ->whereDate('start_date', '<=', $currentDate)
            ->whereDate('end_date', '>=', $currentDate)
            ->select('id', 'title', 'description', 'promotion_type', 'discount_type', 'percent', 'amount', 'start_date', 'end_date')
            ->paginate(10);

        $promotions->transform(function ($promotion) {
            unset($promotion->products);
            $promotion->products = $promotion->activeProducts->map(function ($product) {
                $product = [
                    'id' => $product->id,
                    // 'name' => $product->name,
                    // 'description' => $product->description,
                    // 'brand_id' => $product->brand_id,
                    // 'status' => $product->status,
                    // 'product_info' => $product->product_info,
                    // 'rating' => $product->rating,
                    // 'count_product_sale' => $product->count_product_sale,
                    // 'productgallery' => $product->productgallery ? array_map(function($image) {
                    //     return asset('uploads/products/' . $image);
                    // }, $product->productgallery->images) : null
                ];
                return $product;
            });
            unset($promotion->activeProducts);

            $promotion->brands = $promotion->activeBrands->map(function ($brand) {
                $brand = [
                    'id' => $brand->id,
                    // 'name' => $brand->name,
                    // 'images_url' => $brand->images_url
                ];
                return $brand;
            });
            unset($promotion->activeBrands);

            if ($promotion->promotiongallery && is_array($promotion->promotiongallery->images)) {
                $images = $promotion->promotiongallery->images ?? [];
                $promotion->images = !empty($images)
                    ? array_map(function($image) {
                        return asset('uploads/promotions/' . $image);
                    }, $images)
                    : null;
            } else {
                $promotion->images = null;
            }
            unset($promotion->promotiongallery);

            return $promotion;
        });

        if ($promotions->isEmpty()) {
            return response()->json(['message' => 'No records found'], 404);
        }

        return response()->json($promotions, 200);
    }

    public function getPromotionDetail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $id = $request->input('id');
        $currentDate = Carbon::now();

        $promotion = Promotion::where('id', $id)
            ->where('status', 1)
            ->whereDate('start_date', '<=', $currentDate)
            ->whereDate('end_date', '>=', $currentDate)
            ->with('activeProducts.productgallery', 'activeBrands')
            ->with(['promotiongallery' => function ($query) {
                $query->select('id', 'promotion_id', 'images');
            }])
            ->first();

        if (!$promotion) {
            return response()->json(['error' => 'Promotion not found'], 404);
        }

        unset($promotion->created_at, $promotion->updated_at);

        $promotion->products = $promotion->activeProducts->map(function ($product) {
            $productData = [
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'brand_id' => $product->brand_id,
                'status' => $product->status,
                'product_info' => $product->product_info,
                'rating' => $product->rating,
                'count_product_sale' => $product->count_product_sale,
                'new_arrival' => $product->new_arrival,
                'recommended' => $product->recommended,
                'popular' => $product->popular
            ];

            if ($product->productgallery && is_array($product->productgallery->images)) {
                $images = $product->productgallery->images ?? [];
                $productData['images'] = !empty($images)
                    ? array_map(function($image) {
                        return asset('uploads/products/' . $image);
                    }, $images)
                    : null;
            } else {
                $productData['images'] = null;
            }

            return $productData;
        });
        unset($promotion->activeProducts);

        $promotion->brands = $promotion->activeBrands->map(function ($brand) {
            return [
                'id' => $brand->id,
                'name' => $brand->name,
                'images_url' => $brand->images_url ? asset('uploads/brands/' . $brand->images_url) : null // Safe URL generation
            ];
        });
        unset($promotion->activeBrands);

        if ($promotion->promotiongallery && is_array($promotion->promotiongallery->images)) {
            $promotion->images = array_map(function ($image) {
                return asset('uploads/promotions/' . $image);
            }, $promotion->promotiongallery->images);
        } else {
            $promotion->images = [];
        }
        unset($promotion->promotiongallery); // Remove promotiongallery from the response

        return response()->json($promotion, 200);
    }

    // Order
    public function storeOrder(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'order_type' => 'required|in:pickup,delivery',
            'delivery_type' => 'nullable|string',
            'delivery_fee' => 'nullable|numeric',
            'address' => 'nullable|array',
            'payment_method' => 'nullable|in:pay_at_store,cash_on_delivery,aba,wing,acleda',
            'order_details' => 'required|array',
            'order_details.*.product_id' => 'required|exists:products,id',
            'order_details.*.brand_id' => 'required|exists:brands,id',
            'order_details.*.product_qty' => 'required|integer|min:1',
            'order_details.*.product_price' => 'required|numeric',
            'order_details.*.product_size' => 'required|string',
            'order_details.*.discount' => 'nullable|numeric',
            'order_details.*.discount_type' => 'nullable|in:amount,percent',
            'pay_slip' => 'nullable|file|mimes:jpg,jpeg,png,pdf,webp',
        ]);

        try {
            // dd($request->all());
            DB::beginTransaction();

            // Calculate totals
            $order_amount = 0;
            $discount_amount = 0;
            $final_total = 0;

            foreach ($validated['order_details'] as $detail) {
                $subtotal = $detail['product_price'] * $detail['product_qty'];
                $order_amount += $subtotal;

                if (!empty($detail['discount']) && !empty($detail['discount_type'])) {
                    if ($detail['discount_type'] === 'percent') {
                        $discount_value = ($detail['discount'] / 100) * $detail['product_price'];
                    } else {
                        $discount_value = $detail['discount'];
                    }
                    $discount_amount += $discount_value * $detail['product_qty'];
                }
            }

            // Create the base Order
            $order = Order::create(array_merge($validated, [
                'order_amount' => $order_amount,
                'discount_amount' => $discount_amount,
                'final_total' => 0,
            ]));

            // Generate invoice reference
            $datePrefix = now()->format('ymd');
            $order->invoice_ref = "INV-{$datePrefix}00{$order->id}";
            $order->save();

            // Optional address override
            if (isset($validated['address']) && !empty($validated['address'])) {
                $order->address = $validated['address'];
                $order->save();
            }

            // Set delivery vs pickup logic
            if ($validated['order_type'] == 'pickup') {
                $order->delivery_fee = 0;
                $order->order_status = 'pending';
                $order->delivery_type = 'pickup';
                $order->final_total = $order_amount - $discount_amount;
            } else {
                $order->delivery_fee = $validated['delivery_fee'];
                $order->order_status = 'pending';
                $order->delivery_type = $validated['delivery_type'];
                $order->final_total = $order_amount - $discount_amount + $validated['delivery_fee'];
            }
            $order->save();

            // Handle pay_slip upload & payment_status
            if ($request->file('pay_slip')) {
                $image_name = time() . '.' . $request->pay_slip->extension();
                if ($order->pay_slip) {
                    if (file_exists(public_path('uploads/payments/' . $order->pay_slip))) {
                        unlink(public_path('uploads/payments/' . $order->pay_slip));
                    }
                }

                $request->pay_slip->move(public_path('uploads/payments'), $image_name);
                $order->pay_slip = $image_name;
                $order->payment_status = 'paid';
            } else {
                $order->payment_status = 'unpaid';
            }
            $order->save();

            // Create OrderDetail rows & adjust inventory
            foreach ($validated['order_details'] as $detail) {
                $order_detail = new OrderDetail();
                $order_detail->order_id = $order->id;
                $order_detail->product_id = $detail['product_id'];
                $order_detail->brand_id = $detail['brand_id'];
                $order_detail->product_qty = $detail['product_qty'];
                $order_detail->product_price = $detail['product_price'];
                $order_detail->product_size = $detail['product_size'];
                $order_detail->discount = $detail['discount'] ?? 0;
                $order_detail->discount_type = $detail['discount_type'] ?? null;
                $order_detail->save();

                $product = Product::findOrFail($detail['product_id']);
                $productInfo = $product->product_info;
                $productInfoArray = is_array($productInfo) ? $productInfo : json_decode($productInfo, true);

                $matchingSize = null;
                foreach ($productInfoArray as &$info) {
                    if ($info['product_size'] === $detail['product_size']) {
                        $matchingSize = &$info;
                        break;
                    }
                }

                if ($matchingSize) {
                    if ($matchingSize['product_qty'] >= $detail['product_qty']) {
                        $matchingSize['product_qty'] -= $detail['product_qty'];
                    } else {
                        throw new \Exception(
                            "Insufficient quantity for product ID {$detail['product_id']} (Size: {$detail['product_size']}). Available: {$matchingSize['product_qty']}, Requested: {$detail['product_qty']}"
                        );
                    }
                } else {
                    throw new \Exception("Product size {$detail['product_size']} not found for product ID {$detail['product_id']}.");
                }

                $product->product_info = array_map(function ($info) {
                    $info['product_qty'] = (string) $info['product_qty'];
                    return $info;
                }, $productInfoArray);

                $product->increment('count_product_sale', $detail['product_qty']);
                $product->save();
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Order successfully created',
                'data' => $order->load('details')
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to order',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function orderHistory(Request $request)
    {
        $orders = Order::with('details')
            ->where('customer_id', auth()->user()->id)
            ->paginate(10);

        if ($orders->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found'
            ], 404);
        }

        $transformedOrders = $orders->getCollection()->map(function ($order) {
            return [
                'id' => $order->id,
                'invoice_ref' => $order->invoice_ref,
                'customer_id' => $order->customer_id,
                'order_status' => $order->order_status,
                'payment_status' => $order->payment_status,
                'created_at' => $order->created_at,
                'qty' => $order->details->sum('product_qty'),
                'total' => $order->final_total,
            ];
        });

        $paginated = $orders->toArray();
        $paginated['data'] = $transformedOrders;

        return response()->json([
            'success' => true,
            'data' => $paginated
        ], 200);
    }

    public function orderDetail(Request $request)
    {
        $request->validate([
            'order_id' => 'required'
        ]);

        $order = Order::with(['details.product', 'statusHistories'])
            ->where('customer_id', auth()->user()->id)
            ->where('id', $request->order_id)
            ->first();

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found'
            ], 404);
        }

        $filteredDetails = $order->details->map(function ($detail) {
            $images = $detail->product->productgallery->images;
            $image  = $images[0] ?? null;

            return [
                'id'             => $detail->id,
                'order_id'       => $detail->order_id,
                'product_id'     => $detail->product_id,
                'brand_id'       => $detail->brand_id,
                'product_name'   => $detail->product->name,
                'product_qty'    => $detail->product_qty,
                'product_size'   => $detail->product_size,
                'product_price'  => $detail->product_price,
                'discount'       => $detail->discount,
                'discount_type'  => $detail->discount_type,
                'image_url'      => $image ? asset('uploads/products/' . $image) : null,
            ];
        });

        $filteredOrder = [
            'id'              => $order->id,
            'invoice_ref'     => $order->invoice_ref,
            'customer_id'     => $order->customer_id,
            'order_status'    => $order->order_status,
            'delivery_type'   => $order->delivery_type,
            'payment_method'  => $order->payment_method,
            'payment_status'  => $order->payment_status,
            'created_at'      => $order->created_at->toDateTimeString(),
            'order_amount'    => floatval($order->order_amount),
            'discount_amount' => floatval($order->discount_amount),
            'delivery_fee'    => $order->delivery_fee ? floatval($order->delivery_fee) : 0,
            'final_total'     => floatval($order->final_total),
            'details'         => $filteredDetails,
        ];

        $filteredOrder['tracking'] = $order->statusHistories
            ->map(function ($h) {
                return [
                    'status'    => $h->status,
                    'timestamp' => $h->updated_at->format('Y-m-d H:i:s'),
                ];
            })
            ->values()
            ->toArray();

        return response()->json([
            'success' => true,
            'data'    => $filteredOrder
        ], 200);
    }

    public function customerProfile(Request $request)
    {
        $customer = [
            'id' => auth()->user()->id,
            'image_url' => auth()->user()->image_url,
            'name' => auth()->user()->name,
            'phone' => auth()->user()->phone,
            'email' => auth()->user()->email,
            'provider' => auth()->user()->provider,
            'is_google_login' => auth()->user()->provider == 'google' ? 1 : 0,
        ];
        return response()->json($customer);
    }

    public function updateCustomerProfile(Request $request)
    {
        $customer = Customer::find(auth()->id());

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'old_password' => ['nullable', 'string', 'min:6'],
            'new_password' => ['nullable', 'string', 'min:6'],
            'phone' => ['nullable', 'string'],
            'email' => ['nullable', 'string', 'email', 'max:255', Rule::unique('customers', 'email')->ignore($customer->id)],
        ];

        if ($customer->provider === 'google') {
            $rules['email'] = [
                'nullable',
                'string',
                'email',
                'max:255',
                Rule::unique('customers', 'email')->ignore($customer->id),
            ];
        }

        $request->validate($rules);

        $customer->name = $request->name;

        if ($request->has('phone') && $request->phone !== null) {
            $customer->phone = $request->phone;
        }

        if ($request->has('email') && $request->email !== null) {
            $customer->email = $request->email;
        }

        if ($request->filled('new_password')) {
            if (!Hash::check($request->old_password, $customer->password)) {
                return response()->json(['message' => 'Old password is incorrect.'], 403);
            }
            $customer->password = $request->new_password;
        }

        if ($request->file('image')) {
            $image_name = time() . '.' . $request->image->extension();
            if ($customer->image) {
                if (file_exists(public_path('uploads/customers/' . $customer->image))) {
                    unlink(public_path('uploads/customers/' . $customer->image));
                }
            }

            $request->image->move(public_path('uploads/customers'), $image_name);
            $customer->image = $image_name;
        }

        $customer->save();

        $customer = [
            'id' => auth()->id(),
            'image_url' => $customer->image_url,
            'name' => $customer->name,
            'phone' => $customer->phone,
            'email' => $customer->email,
            'provider' => $customer->provider,
            'is_google_login' => $customer->provider == 'google' ? 1 : 0,
        ];

        return response()->json($customer);
    }
}
