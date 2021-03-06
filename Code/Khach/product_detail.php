<?php
session_start();
include 'function/function_connect_db.php';
include 'function/function_show_database.php';
include 'function/function_find_database.php';
include 'function/function_money_format.php';

if (isset($_COOKIE['email_kh']) && !empty($_COOKIE['email_kh'])) {
    $email_kh = $_COOKIE['email_kh'];
}

if (isset($_COOKIE['password_kh']) && !empty($_COOKIE['password_kh'])) {
    $password_kh = $_COOKIE['password_kh'];
}

if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
}
?>

<?php
if (isset($_GET['id_product']) && !empty($_GET['id_product'])) {
    $id_sp = $_GET['id_product'];
    $result_product = get_sanpham($id_sp);
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title><?php echo $result_product['ten_sp'] ?> - HT SHOP</title>

        <script src="vendor/jquery/jquery.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

        <script src="javascript/javascript-ajax-login.js"></script>
        <script src="javascript/javascript-ajax-cart-management.js"></script>
        <script src="javascript/javascript-ajax-order-management.js"></script>

        <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css" type="text/css">
        <link rel="stylesheet" href="vendor/font-awesome/css/font-awesome.min.css" type="text/css">

        <link rel="stylesheet" href="styles/style-base.css" type="text/css">
        <link rel="stylesheet" href="styles/style-product-details.css" type="text/css">
    </head>

    <body id="top">
        <!-- navbar header -->
        <?php
        include 'nav_header.php';
        ?>

        <!-- modal login -->
        <?php
        include 'modal_login.php';
        ?>

        <!-- modal notification -->
        <?php
        include 'modal_notification.php';
        ?>

        <!-- navbar menu (ch???c n??ng) -->
        <?php
        include 'nav_menu.php';
        ?>

        <!-- Breadcrumb -->
        <?php
        include 'breadcrumb.php';
        ?>

        <!-- hi???n th??? chi ti???t s???n ph???m -->
        <div class="container mg-2">
            <div class="row bg-white m-1 pt-4 rounded">
                <!-- hi???n th??? h??nh ???nh -->
                <div class="col-md-7">
                    <div id="image_product" class="carousel slide" data-ride="carousel" data-interval="100000">
                        <ol class="carousel-indicators">
                            <li data-target="#image_product" data-slide-to="0" class="active"></li>
                            <li data-target="#image_product" data-slide-to="1"></li>
                            <li data-target="#image_product" data-slide-to="2"></li>
                            <li data-target="#image_product" data-slide-to="3"></li>
                        </ol>
                        <div class="carousel-inner rounded">
                            <div class="carousel-item active">
                                <!-- bi???n  $result_product l???y ph??a tr??n tilte-->
                                <img src="<?php echo $result_product['anh_sp'] ?>" class="d-block w-100 object-fit-contain image-product-detail" alt="First slide">
                            </div>

                            <?php
                            // bi???n $id_sp l???y tr??n tilte
                            $query_anhsanpham = get_anhsanpham($id_sp);
                            while ($result_anhsanpham = mysqli_fetch_array($query_anhsanpham)) {
                            ?>
                                <div class="carousel-item">
                                    <img src="<?php echo $result_anhsanpham['anh_asp'] ?>" class="d-block w-100 object-fit-contain image-product-detail" alt="Second slide">
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                        <a class="carousel-control-prev" href="#image_product" role="button" data-slide="prev">
                            <div class="background-blue p-1 pt-2 rounded">
                                <span class="carousel-control-prev-icon icon-slider" aria-hidden="true"></span>
                            </div>
                        </a>
                        <a class="carousel-control-next" href="#image_product" role="button" data-slide="next">
                            <div class="background-blue p-1 pt-2 rounded">
                                <span class="carousel-control-next-icon icon-slider" aria-hidden="true"></span>
                            </div>
                        </a>
                    </div>
                </div>
                <!-- hi???n th??? t??n, gi?? s???n ph???m -->
                <div class="col-md-5 pl-1 mb-2">
                    <div class="bg-white">
                        <p class="text-name-product-detail"><?php echo $result_product['ten_sp'] ?></p>
                        <p class="icon-star">
                            <i class="fa fa-star " aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star-half-o" aria-hidden="true"></i>
                        </p>

                        <?php
                        if (isset($_GET['id_product']) && !empty($_GET['id_product'])) {
                            $id_sp = $_GET['id_product'];
                            $result_product = get_sanpham($id_sp);
                            $nuocsanxuat = get_nuocsanxuat($result_product['id_nsx']);
                            $khuyenmai = get_khuyenmai($result_product['id_km']);
                            $gia_old = $result_product['gia_sp'];
                            $gia_new = price_after_promotion($gia_old, $khuyenmai['giam_km']);
                            $id_lsp = $result_product['id_lsp'];
                            switch ($id_lsp) {
                                case "DT":
                                    $result_dienthoai = get_dienthoai($id_sp);
                                    $bonho = get_bonho($result_dienthoai['id_bn']);
                                    $ram = get_ram($result_dienthoai['id_ram']);
                                    $thuonghieu = get_thuonghieu($result_dienthoai['id_th']);
                                    $hedieuhanh = get_hedieuhanh($result_dienthoai['id_hdh']);
                                    $thietke = get_thietke($result_dienthoai['id_tk']);
                                    $chip = get_chip($result_dienthoai['id_chip']);
                                    $manhinh = get_manhinh($result_dienthoai['id_mh']);
                                    break;

                                case "TN":
                                    $result_tainghe = get_tainghe($id_sp);
                                    $thuonghieu = get_thuonghieu($result_tainghe['id_th']);
                                    $loaiketnoi = get_loaiketnoi($result_tainghe['id_lkn']);
                                    break;
                                case "OL":
                                    $result_oplung = get_oplung($id_sp);
                                    $thuonghieu = get_thuonghieu($result_oplung['id_th']);
                                    $chatlieu = get_chatlieu($result_oplung['id_cl']);
                                    break;
                            }
                        }

                        if ($result_product['id_ttsp'] != "NKD") {
                        ?>
                            <!-- hi???n th??? gi?? c?? -->
                            <?php
                            if ($khuyenmai['giam_km'] != 0) {
                            ?>
                                <p class="text-price-old-detail"><?php echo money_format($gia_old) ?></p>
                                <!-- hi???n th??? gi?? m???i -->
                                <p class="text-price-new-detail"><?php echo money_format($gia_new) . " VN?? (Gi???m " . $khuyenmai['giam_km'] . "%)" ?></p>

                            <?php
                            } else {
                            ?>
                                <p></p>
                                <!-- hi???n th??? gi?? m???i -->
                                <p class="text-price-new-detail"><?php echo money_format($gia_new) . " VN??" ?></p>
                            <?php
                            }
                            ?>


                            <div class="mb-2">
                                <!-- khi nh???n n??t mua v?? th??m v??o gi??? h??ng th?? ki???m tra t??? input xem c?? ????ng nh???p ch??a qua input "insert_cart_user" -->
                                <?php
                                if (isset($_SESSION['user']) && !empty($_SESSION['user'])) {
                                ?>
                                    <input hidden id="insert_cart_user" value="<?php echo $_SESSION['user']['id_kh'] ?>" type="text">
                                <?php
                                } else {
                                ?>
                                    <input hidden id="insert_cart_user" value="" type="text">
                                <?php
                                }
                                ?>

                                <?php
                                if ($result_product['so_luong_sp'] != "0") {
                                ?>
                                    <p>
                                        Tr???ng th??i s???n ph???m: c??n <?php echo money_format($result_product['so_luong_sp']) ?> s???n ph???m
                                    </p>
                                    <a id="btn-datmua" href="order.php?order_id_product=<?php echo $result_product['id_sp'] ?>" type="button" class="btn rounded btn-buy mr-1">
                                        <i class="fa fa-hand-pointer-o" aria-hidden="true"></i>
                                        &nbsp;?????t Mua
                                    </a>
                                    <button id="btn-add-cart" name="btn-add-cart" value="<?php echo $result_product['id_sp'] ?>" type="button" class="btn rounded btn-add-cart">
                                        <i class="fa fa-cart-plus" aria-hidden="true"></i>
                                        &nbsp;Th??m V??o Gi??? H??ng
                                    </button>
                                <?php
                                } else {
                                ?>
                                    <p>
                                        Tr???ng th??i s???n ph???m: <font style="color: red; font-weight: bold;">H???t H??ng</font>
                                    </p>
                                <?php
                                }
                                ?>

                            </div>
                            <div class="border border-primary mt-2">
                                <div class="text-header-warranty">
                                    Ch??nh S??ch B???o H??nh
                                </div>
                                <p class="m-2 text-content-warranty">
                                    <i class="fa fa-shield text-primary" aria-hidden="true"></i>
                                    B???o H??nh Ch??nh H??ng 2 N??m
                                </p>
                                <p class="m-2 text-content-warranty">
                                    <i class="fa fa-wrench text-primary" aria-hidden="true"></i>
                                    H?? G?? ?????i N???y
                                </p>
                            </div>
                        <?php
                        } else {
                        ?>
                            <!-- hi???n th??? th??ng b??o s???n ph???m NG??NG KINH DOANH -->
                            <p class="text-price-new-detail">NG??NG KINH DOANH</p>
                        <?php
                        }
                        ?>

                    </div>
                </div>


                <div class="col-md-12 mt-2">
                    <p>
                        <button class="btn btn-product-detail-default" type="button" id="btn-product-introduction">
                            Gi???i Thi???u S???n Ph???m
                        </button>
                        <button class="btn btn-product-detail" type="button" id="btn-product-configuration-information">
                            Th??ng Tin C???u H??nh
                        </button>
                    </p>
                    <!-- hi???n th??? gi???i thi???u -->
                    <div class="collapse show" id="intro-content">
                        <div class="card card-body min-height-400">
                            <p class="text-header-info">Gi???i Thi???u S???n Ph???m</p>
                            <div class="text-content-intro">
                                <p>
                                    <?php echo $result_product['gioi_thieu_sp'] ?>
                                </p>
                                <a href="#top" class="btn btn-secondary btn-sm float-right">
                                    L??n ?????u Trang
                                    <i class="fa fa-arrow-up" aria-hidden="true"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- hi???n th??? c???u h??nh smartphone -->
                    <?php
                    if ($id_lsp == "DT") {
                    ?>
                        <div class="collapse" id="configuration-information-content">
                            <div class="card card-body min-height-400">
                                <p class="text-header-info">Th??ng Tin C???u H??nh</p>
                                <table class="table w-50 mx-auto shadow">
                                    <thead class="thead-light">
                                        <tr>
                                            <th colspan="2" class="text-table-header-config-info">B??? Nh??? Trong</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-table-content">
                                        <tr>
                                            <th>Dung l?????ng b??? nh???:</th>
                                            <td><?php echo $bonho['dung_luong_bn'] ?></td>
                                        </tr>
                                    </tbody>

                                    <thead class="thead-light">
                                        <tr>
                                            <th colspan="2" class="text-table-header-config-info">RAM</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-table-content">
                                        <tr>
                                            <th>Dung l?????ng RAM:</th>
                                            <td><?php echo $ram['dung_luong_ram'] ?></td>
                                        </tr>
                                    </tbody>

                                    <thead class="thead-light">
                                        <tr>
                                            <th colspan="2" class="text-table-header-config-info">Th????ng Hi???u</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-table-content">
                                        <tr>
                                            <th>T??n th????ng hi???u:</th>
                                            <td><?php echo $thuonghieu['ten_th'] ?></td>
                                        </tr>
                                    </tbody>

                                    <thead class="thead-light">
                                        <tr>
                                            <th colspan="2" class="text-table-header-config-info">H??? ??i???u H??nh</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-table-content">
                                        <tr>
                                            <th>H??? ??i???u h??nh:</th>
                                            <td><?php echo $hedieuhanh['ten_hdh'] ?></td>
                                        </tr>
                                    </tbody>

                                    <thead class="thead-light">
                                        <tr>
                                            <th colspan="2" class="text-table-header-config-info">Thi???t K???</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-table-content">
                                        <tr>
                                            <th>Ki???u thi???t k???:</th>
                                            <td><?php echo $thietke['kieu_tk'] ?></td>
                                        </tr>
                                    </tbody>

                                    <thead class="thead-light">
                                        <tr>
                                            <th colspan="2" class="text-table-header-config-info">Chip X??? L??</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-table-content">
                                        <tr>
                                            <th>T??n Chip x??? l??:</th>
                                            <td><?php echo $chip['ten_chip'] ?></td>
                                        </tr>
                                    </tbody>

                                    <thead class="thead-light">
                                        <tr>
                                            <th colspan="2" class="text-table-header-config-info">M??n H??nh</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-table-content">
                                        <tr>
                                            <th>K??ch th?????c m??n h??nh:</th>
                                            <td><?php echo $manhinh['kich_thuoc_mh'] ?></td>
                                        </tr>
                                    </tbody>

                                    <thead class="thead-light">
                                        <tr>
                                            <th colspan="2" class="text-table-header-config-info">N?????c S???n Xu???t</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-table-content">
                                        <tr>
                                            <th>Xu???t x???:</th>
                                            <td><?php echo $nuocsanxuat['ten_nsx'] ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="float-right">
                                    <a href="#top" class="btn btn-secondary btn-sm float-right">
                                        L??n ?????u Trang
                                        <i class="fa fa-arrow-up" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php
                        //hi???n th??? c???u h??nh tai nghe
                    } else if ($id_lsp == "TN") {
                    ?>
                        <div class="collapse" id="configuration-information-content">
                            <div class="card card-body min-height-400">
                                <p class="text-header-info">Th??ng Tin C???u H??nh</p>
                                <table class="table w-50 mx-auto shadow">
                                    <thead class="thead-light">
                                        <tr>
                                            <th colspan="2" class="text-table-header-config-info">Th????ng Hi???u</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-table-content">
                                        <tr>
                                            <th>T??n th????ng hi???u:</th>
                                            <td><?php echo $thuonghieu['ten_th'] ?></td>
                                        </tr>
                                    </tbody>

                                    <thead class="thead-light">
                                        <tr>
                                            <th colspan="2" class="text-table-header-config-info">Lo???i K???t N???i</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-table-content">
                                        <tr>
                                            <th>Lo???i k???t n???i:</th>
                                            <td><?php echo $loaiketnoi['ten_lkn'] ?></td>
                                        </tr>
                                    </tbody>

                                    <thead class="thead-light">
                                        <tr>
                                            <th colspan="2" class="text-table-header-config-info">N?????c S???n Xu???t</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-table-content">
                                        <tr>
                                            <th>N?????c s???n xu???t:</th>
                                            <td><?php echo $nuocsanxuat['ten_nsx'] ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php
                        //hi???n th??? c???u h??nh ???p l??ng
                    } else if ($id_lsp == "OL") {
                    ?>
                        <div class="collapse" id="configuration-information-content">
                            <div class="card card-body min-height-400">
                                <p class="text-header-info">Th??ng Tin C???u H??nh</p>
                                <table class="table w-50 mx-auto shadow">
                                    <thead class="thead-light">
                                        <tr>
                                            <th colspan="2" class="text-table-header-config-info">Th????ng Hi???u</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-table-content">
                                        <tr>
                                            <th>T??n th????ng hi???u:</th>
                                            <td><?php echo $thuonghieu['ten_th'] ?></td>
                                        </tr>
                                    </tbody>

                                    <thead class="thead-light">
                                        <tr>
                                            <th colspan="2" class="text-table-header-config-info">Ch???t Li???u</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-table-content">
                                        <tr>
                                            <th>Ch???t li???u:</th>
                                            <td><?php echo $chatlieu['ten_cl'] ?></td>
                                        </tr>
                                    </tbody>

                                    <thead class="thead-light">
                                        <tr>
                                            <th colspan="2" class="text-table-header-config-info">N?????c S???n Xu???t</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-table-content">
                                        <tr>
                                            <th>N?????c s???n xu???t:</th>
                                            <td><?php echo $nuocsanxuat['ten_nsx'] ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>


        <!-- footer -->
        <?php
        include 'footer.php';
        ?>


        <!-- ############################### script ##################################### -->
        <script>
            $(function() {
                // click n??t xem gi???i thi???u s???n ph???m
                $('#btn-product-introduction').click(function() {
                    $('#intro-content').addClass('show');
                    $('#configuration-information-content').removeClass('show');
                    $('#btn-product-introduction').css("background", "#007bff");
                    $('#btn-product-configuration-information').css("background", "grey");
                })
                //click n??t xem c???u h??nh s???n ph???m
                $('#btn-product-configuration-information').click(function() {
                    $('#intro-content').removeClass('show');
                    $('#configuration-information-content').addClass('show');
                    $('#btn-product-introduction').css("background", "grey");
                    $('#btn-product-configuration-information').css("background", "#007bff");
                })
            })
        </script>


    </body>

    </html>
<?php
}
?>