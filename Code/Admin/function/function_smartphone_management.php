<?php
include 'function_connect_db.php';
include 'function_upload_image.php';
include 'function_update_image.php';

//them dien thoai
if (isset($_POST['insert_ten_smartphone'])) {
    $nuocsanxuat = $_POST['insert_nsx_smartphone'];
    $ten = $_POST['insert_ten_smartphone'];
    $gia = $_POST['insert_gia_smartphone'];
    $so_luong = $_POST['insert_so_luong_smartphone'];
    $khuyenmai = $_POST['insert_khuyenmai_smartphone'];
    $bonho = $_POST['insert_bonho_smartphone'];
    $ram = $_POST['insert_ram_smartphone'];
    $thuonghieu = $_POST['insert_thuonghieu_smartphone'];
    $hedieuhanh = $_POST['insert_hedieuhanh_smartphone'];
    $thietke = $_POST['insert_thietke_smartphone'];
    $chip = $_POST['insert_chip_smartphone'];
    $manhinh = $_POST['insert_manhinh_smartphone'];
    $gioi_thieu = $_POST['insert_gioi_thieu_smartphone'];

    //đường dẫn lưu ảnh
    $path = "../../uploads/";

    //thêm file xử lý upload hình ảnh vào folder  
    //nếu image_avatar lỗi thì dừng chương trình  
    $file_image_avatar = upload_image_avatar();
    if ($file_image_avatar == false) {
        die();
    }

    $file_image_1 = upload_image_1();
    //nếu image_1 lỗi thì xóa đi image_avatar đã thêm phía trên (image_avatar đúng)
    if ($file_image_1 == false) {
        unlink($path . $file_image_avatar['name']);
        die();
    }
    $file_image_2 = upload_image_2();
    //nếu image_2 lỗi thì xóa đi image_avatar và image_1 đã thêm phía trên (image_avatar và image_1 đúng)
    if ($file_image_2 == false) {
        unlink($path . $file_image_avatar['name']);
        unlink($path . $file_image_1['name']);
        die();
    }
    $file_image_3 = upload_image_3();
    //nếu image_3 lỗi thì xóa đi image_avatar và image_1, image_2 đã thêm phía trên (image_avatar và image_1, image_2 đúng)
    if ($file_image_3 == false) {
        unlink($path . $file_image_avatar['name']);
        unlink($path . $file_image_1['name']);
        unlink($path . $file_image_2['name']);
        die();
    }

    //********************************* insert vao database san pham
    $sql_insert_sanpham = "INSERT INTO `sanpham`(`ten_sp`, `gia_sp`, `so_luong_sp`, `gioi_thieu_sp`, `id_lsp`, `id_nsx`, `id_km`, `id_ttsp`) 
    VALUES ('$ten','$gia','$so_luong','$gioi_thieu','DT','$nuocsanxuat','$khuyenmai','CH')";
    $query_insert_sanpham = mysqli_query($con, $sql_insert_sanpham);

    if ($query_insert_sanpham == false) {
        echo "Có Lỗi Khi Thêm Dữ Liệu Vào CSDL Sản Phẩm <br/> Có thể lỗi trùng tên sản phẩm <br/> Hoặc mục giới thiệu không hỗ trợ hình ảnh nào đó";
        die();
    }

    $id_sp = mysqli_insert_id($con);

     //********************************* insert vao database dienthoai
    $sql_insert_smarmphone = "INSERT INTO `dienthoai`(`id_sp`, `id_bn`, `id_ram`, `id_th`, `id_hdh`, `id_tk`, `id_chip`, `id_mh`) 
    VALUES ('$id_sp','$bonho','$ram','$thuonghieu','$hedieuhanh','$thietke','$chip','$manhinh')";
    $query_insert_smartphone = mysqli_query($con, $sql_insert_smarmphone);

    if ($query_insert_smartphone == false) {
        echo "Có Lỗi Khi Thêm Dữ Liệu Vào CSDL Điện Thoại";
        die();
    }

    //********************************* insert hình ảnh avatar vao database dienthoai
    $path_image_avatar = "../uploads/" . $file_image_avatar['name'];
    $sql_image_avatar = "UPDATE `sanpham` SET `anh_sp`='$path_image_avatar' WHERE id_sp ='$id_sp'";
    $query_image_avatar = mysqli_query($con, $sql_image_avatar);

    if ($query_image_avatar == false) {
        echo "Có Lỗi Khi Thêm Ảnh Avatar Vào CSDL Sản Phẩm";
        die();
    }

    //********************************* insert hình ảnh vào database anhsanpham
    $path_image_1 = "../uploads/" . $file_image_1['name'];
    $sql_image_1 = "INSERT INTO `anhsanpham`(`anh_asp`, `id_sp`) VALUES ('$path_image_1','$id_sp')";
    $query_image_1 = mysqli_query($con, $sql_image_1);
    if ($query_image_1 == false) {
        echo "Có Lỗi Khi Thêm Ảnh 1 Vào CSDL Ảnh Sản Phẩm";
        die();
    }

    $path_image_2 = "../uploads/" . $file_image_2['name'];
    $sql_image_2 = "INSERT INTO `anhsanpham`(`anh_asp`, `id_sp`) VALUES ('$path_image_2','$id_sp')";
    $query_image_2 = mysqli_query($con, $sql_image_2);
    if ($query_image_2 == false) {
        echo "Có Lỗi Khi Thêm Ảnh 2 Vào CSDL Ảnh Sản Phẩm";
        die();
    }

    $path_image_3 = "../uploads/" . $file_image_3['name'];
    $sql_image_3 = "INSERT INTO `anhsanpham`(`anh_asp`, `id_sp`) VALUES ('$path_image_3','$id_sp')";
    $query_image_3 = mysqli_query($con, $sql_image_3);
    if ($query_image_3 == false) {
        echo "Có Lỗi Khi Thêm Ảnh 3 Vào CSDL Ảnh Sản Phẩm";
        die();
    }



    //thông báo cho ajax biết thêm thành công khi không có lỗi
    echo "success";
}



//cập nhật dien thoai
if (isset($_POST['update_ten_smartphone'])) {
    $id = $_POST['update_id_smartphone'];
    $nuocsanxuat = $_POST['update_nsx_smartphone'];
    $ten = $_POST['update_ten_smartphone'];
    $gia = $_POST['update_gia_smartphone'];
    $so_luong = $_POST['update_so_luong_smartphone'];
    $bonho = $_POST['update_bonho_smartphone'];
    $ram = $_POST['update_ram_smartphone'];
    $thuonghieu = $_POST['update_thuonghieu_smartphone'];
    $hedieuhanh = $_POST['update_hedieuhanh_smartphone'];
    $thietke = $_POST['update_thietke_smartphone'];
    $chip = $_POST['update_chip_smartphone'];
    $manhinh = $_POST['update_manhinh_smartphone'];
    $khuyenmai = $_POST['update_khuyenmai_smartphone'];
    $gioi_thieu = $_POST['update_gioi_thieu_smartphone'];
    $trangthaisanpham = $_POST['update_trangthaisanpham_smartphone'];

    //image cũ có dạng đường dẫn uploads/nameImage lấy tên file để xóa ảnh cũ đi và cập nhật ảnh mới trong thư mục và database
    $name_image_avatar_old = $_POST['image_avatar_old'];
    $name_image_1_old = $_POST['image_1_old'];
    $name_image_2_old = $_POST['image_2_old'];
    $name_image_3_old = $_POST['image_3_old'];

    //image mới có dạng chỉ là tên file
    $name_image_avatar_new = $_FILES['image_avatar']['name'];
    $name_image_1_new = $_FILES['image_1']['name'];
    $name_image_2_new = $_FILES['image_2']['name'];
    $name_image_3_new = $_FILES['image_3']['name'];

    // //nếu có chọn Avatar ảnh mới thì xóa ảnh cũ đi và thêm vào ảnh mới
    update_image_avatar($name_image_avatar_new, $name_image_avatar_old, $id);

    // //nếu có chọn ảnh 1 mới thì xóa ảnh cũ đi và thêm vào ảnh mới
    update_image_1($name_image_1_new, $name_image_1_old, $id);

    // //nếu có chọn ảnh 2 mới thì xóa ảnh cũ đi và thêm vào ảnh mới
    update_image_2($name_image_2_new, $name_image_2_old, $id);

    // //nếu có chọn ảnh 3 mới thì xóa ảnh cũ đi và thêm vào ảnh mới
    update_image_3($name_image_3_new, $name_image_3_old, $id);

    //cập nhật thông tin điện thoại khi ảnh ko có lỗi
    $sql_update_sanpham = "UPDATE `sanpham` SET `ten_sp`='$ten',`gia_sp`='$gia',`so_luong_sp`='$so_luong',`gioi_thieu_sp`='$gioi_thieu',
    `id_nsx`='$nuocsanxuat',`id_km`='$khuyenmai',`id_ttsp`='$trangthaisanpham' WHERE id_sp = '$id'";

    $query_update_sanpham = mysqli_query($con, $sql_update_sanpham);

    if ($query_update_sanpham == false) {
        echo "fail";
        die();
    }

    $sql_update_dienthoai = "UPDATE `dienthoai` SET `id_bn`='$bonho',`id_ram`='$ram',`id_th`='$thuonghieu',`id_hdh`='$hedieuhanh',
    `id_tk`='$thietke',`id_chip`='$chip',`id_mh`='$manhinh' WHERE id_sp = '$id'";
    
    $query_update_dienthoai = mysqli_query($con, $sql_update_dienthoai);

    if ($query_update_dienthoai == false) {
        echo "fail";
        die();
    }

    //thông báo cho ajax biết thêm thành công khi không có lỗi
    echo "success";
}
