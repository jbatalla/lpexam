<?php

namespace App\Http\Controllers;

use App\Orders;
use DB;
use Illuminate\Http\Request;
use Illuminate\HttpResponse;
use Illuminate\Html;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

use Illuminate\Html\FormFacade\Form;

use App\Http\Requests;
use App\Http\Controllers\Controller;

#use Laracasts\Flash\Flash;

use App\Http\Controllers\Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

use Szykra\Notifications\Flash;


class OrderController extends Controller
{
    public function __construct()
    {
        #$this->middleware('auth', ['only' => 'create']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $orders = DB::table('orders')->join('customers', 'customers.id', '=', 'orders.customer_id')
        ->select('orders.order_id', 
                    'orders.customer_id',
                    'customers.first_name', 
                    'customers.last_name', 
                    'customers.email', 
                    'customers.address')
        ->addselect(DB::RAW('SUM(orders.product_price) as totalAmount'))  
        ->orderBy('orders.order_id','desc')
        ->groupBy('orders.order_id')
        ->paginate(15);
        
        //->get()
        //$orders = Orders::with('customer')->paginate(10);

        //$product_price = $this->dbgetProductPrice(62);
        //$product_bin = $this->dbgetProductBinLoc(62);
        //$xyValue = $this->dbcalculatePickDistance('A7');

        $order_no = '1000001';
        $xyValue = $this->getOptimumDistance($order_no);


        //foreach ($orders as $order) {
        /*
        for($i = $order_no; $i <= '1000078'; $i++) {
                $xyValue[$i] = $this->getOptimumDistance($order_no);
                DB::table('orders')
                            ->where('order_id', $order_no)
                            ->update( array('remarks' => $xyValue[$i]) );                   
            
        }*/
        




        return view('orders.view',compact('orders','xyValue','order_no'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $allcustomers = \App\Customers::orderBy('first_name')->get();
        $customers = $allcustomers->lists('CustomerFullName', 'id');
        $allproducts = \App\Products::orderBy('product_name')->get();
        $products = $allproducts->lists('ProductShowInfo','id'); //\App\Products::lists('product_name','id');
        return view('orders.create',compact('customers','products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $order_id = $this->getNewOrderId();
        $pick_id = 'P'.$this->getRandomRackNo();
        $warning = array();
        $error = array();
        $totalPrice = 0;
        $totaProducts = count($request->input('products'));
        foreach($request->input('products') as $selected_id){


            //GET Product Price
            $productPrice = $this->dbgetProductPrice($selected_id);
            //GET Bin Location
            $bin = $this->dbgetProductBinLoc($selected_id);
            //GET Distance
            //$psd = $this->dbcalculatePickDistance($bin[0]->bin_location);
            $remarks = $this->dbcalculatePickDistance($bin[0]->bin_location,$totaProducts);

            $finalPrice = $productPrice->price;
            $totalPrice += $finalPrice;

            //QUERY STOCK LEVEL
            $results = $this->dbStockLevel($selected_id);

            if($results[0]->stock_level != 0) {

                //Prepare to insert data in orders table
                $new_order=array(
                    'order_id'                  => $order_id,
                    'customer_id'               => $request->input('customers'),                
                    'product_id'                => $selected_id,
                    'product_price'             => $productPrice->price,
                    'remarks'                   => '',
                    'picking_station'           => $bin[0]->picking_id,
                    'picking_station_distance'  => $remarks['value'].'m',
                );
                $post = new Orders($new_order);
                $post->save();            

                // Saves Warning Message for Low Level Stock
                if($results[0]->stock == 0) {
                    array_push($warning,$results[0]->product_name);
                }

                //DECREMENT STOCK
                $this->dbUpdateStock($selected_id);
            } else {

                if($results[0]->stock_level == 0) {
                    array_push($error,$results[0]->product_name);
                }
            }
        }

        //SHOW IF THERE IS ANY WARNING MESSAGES
        $res = count($warning);
        if($res > 0) {
            foreach ($warning as $re) {
                Flash::warning('Low on stock on: '. $re); 

            }
        }

        //SHOW IF THERE IS ANY ERROR MESSAGES
        $res_e = count($error);
        if($res_e > 0) {
            foreach ($error as $er) {
                Flash::error('No stock available on: '. $er); 
            }
        }        


        //ADD Optimum route to database when empty values
        $order = $this->dbQueryOrders($order_id);
        if(!empty($order) || $order[0]->remarks == '') {
            $add_remarks = $this->getOptimumDistance($order_id);
            DB::table('orders')
                        ->where('order_id', $order_id)
                        ->update( array('remarks' => $add_remarks ) );             
        }


        #FLASH CLASS
        //Flash::message('Your order has been created!'); //blue
        //Flash::warning('Your order has been created!'); //brown
        //Flash::error('Your order has been created!');  //red
        //Flash::success('Your order has been created!');  //green
        //Flash::info('Your order has been created!');  //light blue

        Flash::success('Your order has been created!');
        return redirect('orders');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //Query orders table
        $order = $this->dbQueryOrders($id);

        $totalAmount = $this->dbgetTotalAmount($id);

        $info = array('name'        => $order[0]->first_name.' '.$order[0]->last_name,
                        'email'     => $order[0]->email,
                        'address'   => $order[0]->address,
                        'total'     => $totalAmount,
                        'route'     => $order[0]->remarks
                    );

        $pdi = '';
        return view('orders.show',compact('order','id','info','pdi'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /*
    * ==============================================================================================
    * Custom Queries
    * ==============================================================================================
    */

    /**
     * Query orders table
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */    
    private function dbQueryOrders($id) {
        $results = DB::table('orders')
            ->join('products', 'products.id', '=', 'orders.product_id')
            ->join('customers', 'customers.id', '=', 'orders.customer_id')
            ->select('orders.id', 'orders.order_id', 'customers.first_name', 
                'orders.customer_id','orders.product_id', 'products.product_name','products.bin_location',
                'customers.last_name', 'orders.remarks', 'orders.picking_station','products.sku',
                'customers.email','customers.address','orders.product_price','orders.payment_status', 
                'orders.picking_station_distance')
            ->where('orders.order_id', '=', $id)->get();
        return $results;
    }

    private function dbCustomQueryOrders($id,$picking_station) {
        $results = DB::table('orders')
            ->join('products', 'products.id', '=', 'orders.product_id')
            ->join('customers', 'customers.id', '=', 'orders.customer_id')
            ->select('orders.id', 'orders.order_id', 'customers.first_name', 
                'orders.customer_id','orders.product_id', 'products.product_name','products.bin_location',
                'customers.last_name', 'orders.remarks', 'orders.picking_station',
                'customers.email','customers.address','orders.product_price','orders.payment_status', 
                'orders.picking_station_distance')
            ->addSelect(DB::raw('CASE LENGTH(substr(products.bin_location,2)) WHEN LENGTH(substr(products.bin_location,2)) == 1 THEN 0 || substr(products.bin_location,2) ELSE substr(products.bin_location,2) END  as cnt'))
            ->where('orders.order_id','=',$id)
            ->where('orders.picking_station','=', $picking_station )
            ->orderBy('cnt')
            ->get();
        return $results;        
    }

    /**
     * Get Optimum distance from Point A to products
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    #==============================================================================================
    # USED FOR TESTING
    #==============================================================================================
    private function getOptimumDistance($orderId) {
        //Get which Picking to start with highest count of products 
        $start_ps = $this->getStartPickingStation($orderId); //P1/P2/P3
        $results = '';
        foreach ($start_ps as $ord) {
            //Start calculating the distance of all product from each picking station.
            $results .= $this->calculateDistance($orderId, $ord->picking_station);
        }
        return $results;
    }

    private function calculateDistance($orderId,$start_ps) {     

        //Variable initialize
        $distance = 0;
        $total_distance = 0;
        $dist_arr = array(); 
        $route = '';
        $last_pos ='';
        $x = 1;
        $prev = "";
        $prev_aisle = '';

        /*Get product nearest to $start picking station */
        $start_pro = $this->dbCustomQueryOrders($orderId, $start_ps);
        $count_prod = count($start_pro) - 1;

            for($i=0; $i <= $count_prod; $i++) {
                //GET Bin Location
                $bin = $this->dbgetProductBinLoc($start_pro[$i]->product_id);

                //Set Start position 
                if($x==1) {
                    $start_pos = $start_ps;
                } else {
                    $prev_prod = ($i-1);
                    $prev = $this->dbgetProductBinLoc($start_pro[$prev_prod]->product_id);
                    $start_pos = $prev[0]->bin_location;
                }

                //GET Distance of each product
                $rv = $this->calcProdPerDistance($bin[0]->bin_location,$start_pos,$prev_aisle);
                $prev_aisle = $rv[1];
                $total_distance += $rv[0];
                array_push($dist_arr,array('bin'=>$bin[0]->bin_location,'distance'=>$distance));
                if($start_pro == end($start_pro)) {
                    $last_pos = $bin[0]->bin_location;
                }
                $x++;
            }

                $min = min($dist_arr);
                $route = '<br>ROUTE: From '.$start_ps .' =>';
                    foreach ($dist_arr as $sort) {
                        if($sort == end($dist_arr)) {
                            $route .= ' '.$sort['bin'];  
                       } else {
                            $route .= ' '.$sort['bin'] .' =>'; 
                       }
                    }
                $route .=' ::Total distance of '.$total_distance. 'm.';
                unset($total_distance);
        //Return the route to products        
        return $route;
    }



    private function calcProdPerDistance($id,$start_pos,$prev_aisle) {

        $pos = array("P1", "P2", "P3");
        $prev_aisle_x = '';$prev_aisle_y='';
        if(!empty($prev_aisle)) {
            $ai_xy = explode('-',$prev_aisle);
            $prev_aisle_x = $ai_xy[0];
            $prev_aisle_y = $ai_xy[1];
        }

        //GET aisle ID of product
        $aisle_L = substr($id,0,1); //e.g E1 = E  || F5 = F

        //Query to get the nearest Picking station for products
        $ai = $this->dbgetPickingStation($aisle_L); //e.g. dbgetPickingStation(E) = P3  || = P3
    
        //Pick Stations of product
        $ps_id = $ai[0]->pick_id; // e.g. P1/P2/P3 pick_id = P3 || P3


        //$prodXY = $this->getXYofProduct($start_pos);
        //product X
        $prod_x = $ai[0]->aisle_id;   //aisle_id = 8  || 9
        //product Y
        $prod_y = (substr($id, 1)+1);  //substring(E1,1)+1 = 2 || substring(F5,1)+1 = 6 
        //aisle X Picking Isle position
        $is_x = $ai[0]->free_aisle_id;   // free_aisle_id = 7 || 10
        //aisle Y Picking Isle position
        $is_y = (substr($id, 1)+1);      // substring(E1,1)+1 = 2 || substring(F5,1)+1 = 6 
        //NEXT START XY
        $last_aisle = $is_x.'-'.$is_y;  // 7-2 ||  10-6

        if($is_x != $prev_aisle_x) {
            $start_pos = $ps_id;
        }

        //CHECK IF START WITHIN ARRAY 
        if(in_array($start_pos,$pos)) {
            //Get pick station X/Y 
            $queryPSXY = $this->dbgetPsXY($ai[0]->pick_id); // dbgetPsXY(pick_id = P3) = 8,1

            $px = $queryPSXY[0]->x_val; //Picking Station X  = 8
            $py =  $queryPSXY[0]->y_val; //Picking Station Y  = 1
        } else {           
            $px = ($is_x+1); //Start X    |2>| 11
            $py =  (substr($start_pos, 1)+1); //Start Y   |2>| substr(5, 1)+1 = 6
        }
        
        $disExistingY = 0;
        $disX = 0;
        $disY = 0;
        //Distance of X and Y
        if(in_array($start_pos,$pos)) {
            if($px < $is_x) {  // if 8 < 7  
                $disX = $is_x - $px;   //
            } else {
                $disX = $px - $is_x;   //8 - 7 = 1 
            }
            //Distance of Y
            $disY = $prod_y - $py;   //2 - 1 = 1
        } else {
                $disExistingY = $prod_y - $py; //  |2>|  6 - 6 = 0
        }
        //Total distance from Picking station to product aisle
        $distance = $disExistingY + $disX + $disY;
        //Return String
        $return_string = array('string' => $id.' Product is '.$distance .'m away from '. $ps_id ,'value' => $distance);
       
        /*FOR TEST*/
        $return_array  = array($distance,$last_aisle); //array('3','4-3')
        return  $return_array;
    }



    /**
     * Get value of shortest distance from picking station of product aisle
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    private function dbcalculatePickDistance($id) {

        $aisle_L = substr($id,0,1); //GET aisle ID of product
        $ai = $this->dbgetPickingStation($aisle_L); //Query to get the nearest Picking station for products
        
        $ps_id = $ai[0]->pick_id; //Pick Stations P1/P2/P3 for product
        
        $prod_x = $ai[0]->aisle_id; //product X 
        $prod_y = (substr($id, 1)+1); //product Y

        $is_x = $ai[0]->free_aisle_id; //aisle X Picking Isle position
        $is_y = (substr($id, 1)+1); //aisle Y Picking Isle position

        //Get pick station X/Y 
        $queryPSXY = $this->dbgetPsXY($ai[0]->pick_id);
        $px = $queryPSXY[0]->x_val; //Picking Station X
        $py =  $queryPSXY[0]->y_val; //Picking Station Y

        //Distance of X
        if($px < $is_x) {
            $disX = $is_x - $px;
        } else {
            $disX = $px - $is_x;
        }
        //Distance of Y
        $disY = $prod_y - $py;
        //Total distance from Picking station to product aisle
        $distance = $disX + $disY;
        //Return String
        $return_string = array('string' => $id.' Product is '.$distance .'m away from '. $ps_id ,'value' => $distance);
       
        /*FOR TEST*/


        return  $distance;
    }

    private function getStartPickingStation($id) {
        $results = DB::table('orders')
            ->join('products', 'products.id', '=', 'orders.product_id')
            ->select(DB::raw('orders.picking_station, COUNT(orders.picking_station) as count'))
            ->groupBy('orders.picking_station')
            ->orderBy('count','desc')
            ->where('orders.order_id', '=', $id)->get();
        return $results;         

    }

    /**
     * Get values of aisle info in tblAisle
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    private function dbgetPickingStation($id) {
        $query = DB::table('tblAisle')
                    ->select('aisle_id','pick_id','free_aisle_id')
                    ->where('rack_id', '=', $id)
                    ->get();
        return $query;

    }


    /**
     * Get value of X and Y from picking_station table
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    private function dbgetPsXY($id) {
        $query = DB::table('picking_station')
                    ->select('x_val','y_val')
                    ->where('name', '=', $id)
                    ->get();
        return $query;
    }



    /**
     * Update products table to decrease stock when product is save in Orders
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    private function dbUpdateStock($id) {
        DB::table('products')
            ->where('id', $id)
            ->decrement('stock_level');
    }

    /**
     * Return if the product stock level is below the entered low_level stock
     * Boolean = 0 if below stock; 1 if normal stock value
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    private function dbStockLevel($id) {
        $query = DB::table('products')
                    ->select(DB::raw('CASE WHEN stock_level <= low_level_stock THEN 0 ELSE 1 END AS stock, product_name,stock_level'))
                    ->where('id', '=', $id)
                    ->get();
        return $query;        
    }

    /**
     * Returns product price from products table that will be used in the orders table
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    private function dbgetProductPrice($id) {
        $query = DB::table('products')
                    ->select('price')
                    ->whereId($id)
                    ->first();
        return $query;        
    }

    /**
     * Save Total price in orders table //currently disabled
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    private function dbUpdateTotalPrice($id,$totalPrice) {
        DB::table('orders')
            ->where('order_id', $id)
            ->update(['totalPrice' => $totalPrice]);
    }

    /**
     * Returns Picking station and bin location of product ordered
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */    
    private function dbgetProductBinLoc($id) {
        $binquery = DB::table('products')
                    ->join('productbins', 'productbins.rack_id', '=', 'products.bin_location')
                    ->select('productbins.picking_id','products.bin_location')
                    ->where('products.id','=', $id)
                    ->get();
        return $binquery;         
    }

    /**
     * Returns calculated disctance of product from picking station.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    private function dbcalculatePickDistance1($id) {
        $isles = array('B', 'D', 'F');
        $isle = substr($id, 0,1);

        $distance = substr($id, 1);
        $isles = array('B', 'D', 'F');
        if (in_array($isle, $isles)) {
            return $distance += 1;
        } 
        return $distance;
    }

    /**
     * Returns calculated Total amount of products ordered.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    private function dbgetTotalAmount($id) {
        $orders = DB::table('orders')
        ->join('customers', 'customers.id', '=', 'orders.customer_id')
        ->select(DB::RAW('SUM(orders.product_price) as totalAmount'))
        ->where('orders.order_id', '=', $id)
        ->groupBy('orders.order_id')->first();
        return $orders->totalAmount;
    }

    /*
    * Collection of random function for testing purposes
    */

    /*
    *  Return total number of orders 
    *
    */
    public function ordercount() {
        $orders = Orders::all();
        return count($orders);        
    }

    /*
    *  Return start of order id 
    *
    */
    public function startOrderId() {
        $start_count = 1000001;
        return $start_count;
    }

    /*
    *  Return generated order id based on the last order id created 
    *
    */
    public function generateOrderId() {
        $orders = Orders::orderBy('id', 'desc')->first();
        $newOrderId = $orders->order_id + 1;
        return $newOrderId;
    }

    /*
    *  Return if new order id will be created or generated new from last created
    *
    */
    public function getNewOrderId() {
        if($this->ordercount() == 0) {
            $orderId = $this->startOrderId();
        }else {
            $orderId = $this->generateOrderId();
        } 
        return $orderId;    
    }

    /*
    *  Return rack no.
    *
    */
    public function getRandomRackNo() {
        $input = array("2", "3", "4");
        $rand_keys = array_rand($input,1);
        return $rand_keys;
    }



}
