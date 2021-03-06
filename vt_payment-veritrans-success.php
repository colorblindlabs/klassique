<?php 
include("header.php");

$id_order       = sprintf("%01d",filter_var($_GET['order_id'],FILTER_SANITIZE_STRING));
$status_code    = sprintf("%01d",filter_var($_GET['status_code'],FILTER_SANITIZE_STRING));

$data = global_select_single("order_header","*","id = $id_order");

if(!$data){
    redirect("/".$curr_lang."/index");
}

if(isset($data['tokenpay'])){
    $tokenpay = filter_var($data['tokenpay'],FILTER_SANITIZE_STRING);
    $cek_valid_tokenpay = global_select_single("order_header","*","tokenpay= '".$tokenpay."'");
    if(!$cek_valid_tokenpay){
        $_SESSION['stat'] = 'konfirmasi_bayar_gagal';
        redirect('/'.$curr_lang.'/index');
    }
}

/*data order*/
$order_header       = global_select_single("order_header","*,DATE_FORMAT(date,'%W %d %M %Y - %T') as tanggal","tokenpay = '".$tokenpay."'");
$shipping_note      = $order_header['note'];
$phone_penerima     = $order_header['phone_penerima'];
$address_penerima   = $order_header['address_penerima'];
$nama_penerima      = $order_header['nama_penerima'];
$payment_method     = $order_header['payment_metod'];
$tgl_order          = $order_header['tanggal'];
$order_id           = $order_header['id'];
$order_amount       = $order_header['orderamount'];
$shippingcost       = $order_header['shippingcost'];
$discountamount     = $order_header['discountamount'];
$vouchercode        = $order_header['vouchercode'];
$transfer_amount    = $order_header['orderamount']+$order_header['shippingcost']-$order_header['discountamount'];
$data_detail        = global_select("order_detail","*","tokenpay = '".$tokenpay."'");

$data_payment_method = global_select_single("payment_method","*","payment = '$payment_method'",false,false,false);

$pages_confirmation = global_select_single("pages","*","id = 5");
?>
    </head>
    
    <body class="shop-account">
        <?php include("mobile-menu.php"); ?>
        <div id="wrapper" class="wide-wrap">
            <div class="offcanvas-overlay"></div>
            <?php include("head.php"); ?>
            <div class="heading-container">
                <div class="container heading-standar">
                    <div class="page-breadcrumb">
                        <ul class="breadcrumb">
                            <li><span><a href="/<?php echo $curr_lang ?>/index" class="home"><span><?php echo $language_config[16]['lang_'.$curr_lang] ?></span></a></span></li>
                            <li><span>Payment Complete</span></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="content-container">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 main-wrap">
                            <div class="main-content">
                                <div class="shop">
                                    <div class="checkout-navigation f-g6">
                                        <div class="cn-cart"><span>Cart</span></div>
                                        <div class="cn-checkout"><span>Checkout</span></div>
                                        <div class="cn-done active f-g8"><span>Done</span></div>
                                    </div><!-- .checkout-navigation -->
                                    <div class="row">
                                        <div class="col-md-8 shop-done-wrap" style="text-align:center; font-size:1.38em;">
                                            <h1 class="f-8"><span class="f-green">Payment Successful!</span><br>Thank you for your purchase!</h1>
                                            <p>Your order number: #<?php echo sprintf('%06d',$order_id);?></p>
                                            <?php echo $pages_confirmation['description_'.$curr_lang] ?>
                                        </div><!-- .col-md-8 -->
                                        <div class="col-md-10 shop-done-wrap">
                                            <table class="finish-order-table">
                                                <tr>
                                                    <td colspan="3"><?php echo $tgl_order ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Order Number</th>
                                                    <td>:</td>
                                                    <td>#<?php echo sprintf('%06d',$order_id); ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Nama Penerima</th>
                                                    <td>:</td>
                                                    <td><?php echo $nama_penerima ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Address</th>
                                                    <td>:</td>
                                                    <td><?php echo $address_penerima ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Phone</th>
                                                    <td>:</td>
                                                    <td><?php echo $phone_penerima ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Shipping Note</th>
                                                    <td>:</td>
                                                    <td><?php echo $shipping_note ?></td>
                                                </tr>
                                            </table>
                                            
                                            <table class="table shop_table cart">
                                                <thead>
                                                    <tr>
                                                        <th class="product-thumbnail hidden-xs">&nbsp;</th>
                                                        <th class="product-name">Product</th>
                                                        <th class="product-price text-center" style="text-align:right;">Price</th>
                                                        <th class="product-quantity text-center">Quantity</th>
                                                        <th class="product-subtotal text-center hidden-xs" style="text-align:right;">Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php if($data_detail){foreach ($data_detail as $key => $value) {
                                                        $product = global_select_single("product","*","id = '$value[idproduct]'");
                                                        $product_detail = global_select_single("product_detail_size","*","id = '$value[iddetail]'");
                                                        
                                                        $gender = get_gender_from_id($product_detail['gender'],'product_gender');
                                                        $size   = get_size_from_id($product_detail['size'],'product_size');
                                                        $fit_type = get_fit_from_id($product_detail['fit_type'],'product_type');

                                                        if(isset($value['custom_line1']) AND $value['custom_line1'] != ''){
                                                            $custom_line1 = $value['custom_line1'];
                                                            $addon_price1 = $product['price_custom_line1'];
                                                        }
                                                        if(isset($value['custom_line2']) AND $value['custom_line2'] != ''){
                                                            $custom_line2 = $value['custom_line2'];
                                                            $addon_price2 = $product['price_custom_line2'];
                                                        }
                                                        if(isset($value['base64']) AND $value['base64'] != ''){
                                                            $custom_gambar = '<img width="100" height="100" src="'.$value['base64'].'">';
                                                            $addon_price_gambar = $product['price_custom_gambar'];
                                                        }

                                                    ?>
                                                    <tr class="cart_item">
                                                        <td class="product-thumbnail hidden-xs">
                                                            <a href="#">
                                                                <img width="100" height="150" src="/web/uploads/<?php echo $product['product_image'] ?>" alt="Product-1"/>
                                                            </a>
                                                        </td>
                                                        <td class="product-name">
                                                            <a href="#"><?php echo $product['name'] ?></a>
                                                            <dl class="variation">
                                                                <dt class="variation-Color">Gender:</dt><dd class="variation-Color"><p><?php echo $gender ?></p></dd>
                                                                <dt class="variation-Size">Size:</dt><dd class="variation-Size"><p><?php echo $size ?></p></dd>
                                                                <dt class="variation-Fit">Fit:</dt><dd class="variation-Fit"><p><?php echo $fit_type ?></p></dd>
                                                                <?php 
                                                                if($data_detail){
                                                                    if($value['is_custom'] == 1){
                                                                    echo'<dt class="variation-CustomText">Custom Text Line 1:</dt><dd class="variation-CustomText"><p>'.$value['custom_line1'].'</p></dd>';
                                                                    echo'<dt class="variation-CustomText">Custom Text Line 2:</dt><dd class="variation-CustomText"><p>'.$value['custom_line2'].'</p></dd>';
                                                                    if($value['base64']){
                                                                        echo'<dt class="variation-CustomImage">Custom Image:</dt><dd class="variation-CustomImage"><p><img width="100" height="100" src="'.$value['base64'].'"></p></dd>';
                                                                    }else{
                                                                        echo'<dt class="variation-CustomImage">Custom Image:</dt><dd class="variation-CustomImage"><p>None</p></dd>';
                                                                    }
                                                                    }
                                                                } ?>
                                                            </dl>
                                                        </td>
                                                        <td class="product-price text-center" style="text-align:right;">
                                                            <span class="amount">IDR <?php echo number_format($value['price']) ?></span>
                                                        </td>
                                                        <td class="product-quantity text-center">
                                                            <strong><?php echo $value['qty'] ?></strong>
                                                        </td>
                                                        <td class="product-subtotal hidden-xs text-center" style="text-align:right;">
                                                            <span class="amount">IDR <?php echo number_format($value['price']*$value['qty']) ?></span>
                                                        </td>
                                                    </tr>
                                                    <?php }} ?>
                                                    <tr>
                                                        <td colspan="6" class="f-g6 finish-fee">
                                                            <strong>TOTAL<span>IDR <?php echo number_format($order_amount) ?></span></strong>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="6" class="f-g6 finish-fee">
                                                            SHIPPING FEE<span>IDR <?php echo number_format($shippingcost) ?></span>
                                                        </td>
                                                    </tr>
                                                    <?php if($vouchercode != ''){ ?>
                                                    <tr>
                                                        <td colspan="6" class="f-g6 finish-fee f-green">
                                                            VOUCHER <?php echo $vouchercode ?><span>- IDR <?php echo number_format($discountamount) ?></span>
                                                        </td>
                                                    </tr>
                                                    <?php }?>
                                                    <tr>
                                                        <td colspan="6" class="actions f-g8 cart-gtotal">
                                                            GRAND TOTAL<span>IDR <?php echo number_format($transfer_amount) ?></span>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div><!-- .col-md-10 -->
                                        
                                        <div class="col-md-10 shop-done-wrap">
                                            <div class="cart-collaterals">
                                                <div class="cart_totals">
                                                    <div class="wc-proceed-to-checkout">
                                                        <a href="/<?php echo $curr_lang?>/product-list" class="checkout-button button alt wc-forward" style="min-width:200px;">CONTINUE SHOPPING</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- .col-md-10 -->
                                    </div><!-- .row -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php include("foot.php"); ?>
        </div>
        <?php include("modal.php"); ?>
        <?php include("footer.php"); ?>

<script>
    $(document).ready(function() {
        $("header").removeClass("header-absolute header-transparent");
    });
</script>
</body>
</html>