<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Translate app</title>
</head>
<body>

   <div class="container mt-5 shadow-lg justify-content-center">
        <div class="card-title mt-5">
            <h1 class="text-center titre"><b> Translate a file</b></h1>
        </div>
        <div class="card-body ">
        <form class="row col-6 mt-5" method="post" enctype="multipart/form-data" onsubmit="document.getElementById('btn').classList.add('disabled','true');
        document.getElementById('btn').value='Please wait the file is being translated';
            return true;">
        <?php  if($error === "error"):?>
            <div class="alert alert-danger" role="alert">
                <?=$message ?>
            </div>
        <?php  endif;?>
      
           <div class="row mb-6 mt-5 ">
               <label class="col-sm-4 col-form-label" style="font-weight:bold;">Upload File to translate</label>
               <div class="col-sm-8 ">
                 <div class="input-group mb-5 shadow-lg">
               <input class="form-control form-control-lg" id="fileTrans" name="fileTrans"  accept=".xlsx" type="file">
           </div>
           </div>
            </div>
                <div class="text-center mb-3 mt-2">
               <input type="submit" class="btn btn-primary btn-lg" id="btn" value="Translate">
           </div>
    </form>


<!-- Optional JavaScript; choose one of the two! -->

<!-- Option 1: Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</div>
</div>
</body>
</html>