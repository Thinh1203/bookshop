<?php
  session_start();
  if(isset($_GET['logout'])){
    unset($_SESSION['username']);
  }
?>
<?php
  include '../connect.php';
  use App\Models\Product;
  use App\Models\User;
  use Illuminate\Database\Capsule\Manager as Manager;
 
 
 
  $thanhtien = 0;
  if(isset($_POST['addcart'])){
    $user = user::where('tenDangNhap', $_SESSION['username'])->get('id_user');
    $id = $_GET['id'];
    $query = Product::where('id_product', $id)->get();
    if($user=='[]'){
      header('location: dangnhap.php');
     } else {
      $soluong = $_POST['number'];
      $gia = $_POST['gia'];
      $hinhanh = $_POST['hinhanh']; 
      $thanhtien = (int)$soluong * (int)$gia;
      $idUser = $user[0]->id_user;
  $idProduct = $query[0]->id_product;
  $sum = number_format($thanhtien,'3','','0');

     }
     Manager::insert('insert into user_product(image_product, gia, soLuong, thanhTien, id_user, id_product) values(?,?,?,?,?,?)', [$hinhanh, $gia, $soluong, $sum, $idUser, $idProduct]);

  } 
  if(isset($_GET['id'])){
  Manager::delete('delete from user_product where id=:id',['id' => $_GET['id']]);
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.0/css/all.min.css" rel="stylesheet">
    <link href="../../css/header.css" type="text/css" rel="stylesheet">
    <link href="../../css/body.css" type="text/css" rel="stylesheet">
    <link href="../../css/footer.css" type="text/css" rel="stylesheet">
    <link rel="icon" href="../../image/Logo.jpg" type="image/icon type">
    <title>BookShop</title>
</head>
<body>
  <!--Start header -->
  <header>
    <div class="nav-header">
      <nav class="navbar navbar-expand-md navbar-dark text-center nav_menu">
        <div class="container-fluid">
          <a class="navbar-brand ml-sm-3 mt-n2" href="#"><span class="logo" id="logo-before">Book</span><span class="logo" id="logo-after">Shop</span></a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <ul class="navbar-nav" style="position: relative;">
              <li class="nav-item">
               <a class="nav-link text-white decoration-animation" href="index.php">TRANG CH???</a>
              </li>
              <li class="nav-item toggle">
                  <a class="nav-link text-white decoration-animation" id="list-menu-ok" href="#">TH??? LO???I</a>
                  <div class="list-type-menu">
                  <ul class="list-type">
                    <li><a href="thieunhi.php">S??ch thi???u nhi</a></li>
                    <li><a href="vanhoc.php">S??ch v??n h???c</a></li>
                    <li><a href="kinhte.php">S??ch kinh t???</a></li>
                  </ul>
                </div>               
              </li>
              <li class="nav-item">
                <a class="nav-link text-white decoration-animation" href="#">GI???I THI???U</a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-white decoration-animation" href="#">LI??N H???</a>
              </li> 
            </ul> 
            <div class="nav-item-icon d-flex justify-content-end text-right">  
              <div class="nav-item-search mr-1 flex-fill">
                <form class="form-inline mr-n3" action="timkiem.php" method="POST">
                  <input class=" form-control mr-n1 border-0" type="text" placeholder="Search" name="tukhoa">
                  <button class="btn-primary p-2 border-0" type="submit" name="timkiem">T??m ki???m</button>
                </form>
              </div>
              <div class="nav-item-shopping mt-2">
                <span>
                <a href="addcart.php" alt="shopping-cart"><span id="cart-shopping" ><i class="fa-solid fa-cart-shopping"></i>&nbsp;<sup><span id="cart" class="text-warning"></span></sup></span><span>Gi??? h??ng</span></a>
                </span> 
                <?php
                 // include '../connect.php';
                  
                  if(isset($_SESSION['username'])) {
                    $name = $_SESSION['username'];
                   
                    echo '<span style="color: white;">' . $name . '</span>';
                    
                    echo '<a href="?logout">Tho??t</a>';
                  }else{
                    echo '<a href="dangnhap.php" id="myBtn">????ng nh???p</a> <span style="color: aliceblue;">&sol;</span>                  
                    <a href="dangky.php">????ng k??</a>  ';
                  }
                ?>

              </div>        
            </div>      
        </div> 
      </nav>   
    </div>
  </header>
  <!--End header-->
  <!-- Start main-->
  <main>
    <div class="container bg-light ">
      <div class="row mt-2 bg-dark text-light">
        <div class="col border border-dark text-center">STT</div>
        <div class="col border border-dark text-center">H??nh ???nh</div>
        <div class="col border border-dark text-center">Gi??</div>
        <div class="col border border-dark text-center">S??? l?????ng</div>
        <div class="col border border-dark text-center">Th??nh ti???n</div>
        <div class="col border border-dark text-center">X??a</div>
      </div>
    <?php $cart = Manager::select('select * from user_product'); 
     $GLOBALS['sum'] = 0;
    for($i=0 ; $i < count($cart);){?>
      <div class="row">
        <div class="col text-center pt-2 pb-2"><?php echo ++$i;?></div>
        <div class="col text-center pt-2 pb-2">
        <img  class="d-block w-100 img-fluid "  alt="..." src="../../image/SachKhoaHoc/<?php echo $cart[$i-1]->image_product;?>">  
       </div>
        <div class="col text-center pt-2 pb-2"><?php echo number_format($cart[$i-1]->gia,'3',',',',') . '??';?> </div>
        <div class="col text-center pt-2 pb-2"><?php echo $cart[$i-1]->soLuong;?></div>
        <div class="col text-center pt-2 pb-2"><?php echo number_format($cart[$i-1]->thanhTien,'0','',',') . '??';
        $GLOBALS['sum'] += $cart[$i-1]->thanhTien;?></div>
        <div class="col text-center pt-2 pb-2"><a href="addcart.php?id=<?php echo $cart[$i-1]->id; ?>">Xo??</a></div>
        </div>  
        <?php  }  ?>
        <div class="row bg-dark">
          <div class="col-6"><h4 class="text-right text-light">T???ng ti???n = </h4></div>
          <div class="col-4"><h4 class="text-left text-light"><?php echo number_format($GLOBALS['sum'],'0','',',') .'??';?></h4></div>
          <div class="col-2"><?php if($GLOBALS['sum'] > 0){
          echo '<button class="bg bg-primary text-center text-light p-2" data-toggle="modal" data-target="#myModal"> ?????t h??ng</button>';
        } ?></div>
        </div> 
       
          
          
    </div>
    
    
  </main>
  <!--End main-->
  <!--Footer-->
  <footer>
    <div class="secssion_foot mt-4">
    <div class="row">/br</div>
      
        <div class="row row-cols-1 row-cols-md-4 align-center ml-5 pb-2">
          <div class="col col-md-3">
            <h5 class="title">GI???I THI???U</h5>
            <div class="is-divider divider clearfix" style="max-width:35px;background-color:rgb(195, 0, 5);"></div>
            <p class="footer_content">Ch??o m???ng b???n ?????n v???i ng??i nh?? <span class="logo" id="logo-before" style="font-size: 16px;">Book</span><span style="font-size: 16px;" class="logo" id="logo-after">Shop</span> T???i ????y, m???i m???t d??ng ch???, m???i chi ti???t v?? h??nh ???nh ?????u l?? nh???ng b???ng ch???ng mang d???u ???n l???ch s??? <span class="logo" id="logo-before" style="font-size: 16px;">Book</span><span style="font-size: 16px;" class="logo" id="logo-after">Shop</span> 100 n??m, v?? ??ang kh??ng ng???ng ph??t tri???n l???n m???nh.</p>
          </div>
          <div class="col col-md-3">
          <h5 class="title">?????A CH???</h5>
          <div class="is-divider divider clearfix" style="max-width:35px;background-color:rgb(195, 0, 5);"></div>
          <div class="row">
            <div class="col col-1 text-light"><i class="fa-solid fa-location-dot"></i></div>
            <div class="col col-11"><p class="footer_content">3/2, Ph?????ng Xu??n Kh??nh, Qu???n Ninh Ki???u, Tp.C???n Th??</p></div>
          </div>
          <div class="row">
            <div class="col col-1 text-light"><i class="fa-solid fa-phone"></i></div>
            <div class="col col-11"><p class="footer_content">03451391xx</p></div>
          </div>
          <div class="row">
            <div class="col col-1 text-light"><i class="fa-solid fa-envelope-circle-check"></i></div>
            <div class="col col-11"><p class="footer_content">thinhb1910454@student.ctu.edu.vn</p></div>
          </div>
          <div class="row">
            <div class="col col-1 text-light"><i class="fa-brands fa-skype"></i></div>
            <div class="col col-11"><p class="footer_content">thinhquach</p></div>
          </div>
          </div>
          <div class="col col-md-3">
            <h5 class="title">MENU</h5>
            <div class="is-divider divider clearfix" style="max-width:35px;background-color:rgb(195, 0, 5);"></div>
            <div class="footer_menu "> 
              <div class="row">  
              <div class="col-6">
                <div class="footer_content"><a class="footer_content text-decoration-none" href="#">Trang ch???</a></div>
                <div class="footer_content"><a class="footer_content text-decoration-none" href="#">Gi???i thi???u</a></div>
                <div class="footer_content"><a class="footer_content text-decoration-none" href="#">Tin t???c</a></div>
                <div class="footer_content"><a class="footer_content text-decoration-none" href="#">Li??n h???</a></div>
              </div>
              <div class="col-6">
                <div class="footer_content"><a class="footer_content text-decoration-none" href="#">N???</a></div>
                <div class="footer_content"><a class="footer_content text-decoration-none" href="#">Nam</a></div>
                <div class="footer_content"><a class="footer_content text-decoration-none" href="#">Tr??? em</a></div>
              </div>
            </div>
            </div> 
          </div>
    

          <div class="col col-md-3">
            <h5 class="title">M???NG X?? H???I</h5>
            <div class="is-divider divider clearfix" style="max-width:35px;background-color:rgb(195, 0, 5);"></div>
            <div class="mxh_icon" style="font-size: 190%;">
              <a data-toggle="tooltip" title="Follow on Facebook" href="#" id="facebook"><i class="fa-brands fa-facebook-f"></i></a>
              <a data-toggle="tooltip" title="Follow on Instagram" href="#" id="instagram"><i class="fa-brands fa-instagram"></i></a>
              <a data-toggle="tooltip" title="Follow on Twitter" href="#" id="twitter"><i class="fa-brands fa-twitter"></i></a>
              <a data-toggle="tooltip" title="Follow on Pinterest" href="#" id="pinterest"><i class="fa-brands fa-pinterest-p"></i></a>
              <a data-toggle="tooltip" title="Subscribe to RSS" href="#" id="rss"><i class="fa-solid fa-rss"></i></a>
            </div>
          </div>   
      </div>
    </div>
    <div class=" bg_footer">
      <div class="container">
        <p class="text-center footer_content pt-2 pb-2">&copy; B???n quy???n thu???c v??? <span class="logo" id="logo-before" style="font-size: 16px;">Book</span><span style="font-size: 16px;" class="logo" id="logo-after">Shop</span></p>
      </div>
    </div>
  </footer>
  <!-- The Modal -->
  <div class="modal fade" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">?????t h??ng th??nh c??ng</h4><span></span>
          <button type="button" class="close" data-dismiss="modal">??</button>
        </div>
        
      </div>
    </div>
  </div>
  <!--End footer-->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="../../js/cart.js"></script>
  <script>
    $(function(){
   $(".nav-item.toggle").click(function(){
      $("ul.list-type").slideToggle();
    });
  });
  </script>
<script>
  $(() => {
    $('[data-toggle="tooltip"]').tooltip();   
  });
  </script>
</body>
</html>