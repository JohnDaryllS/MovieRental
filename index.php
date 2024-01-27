<?php
require_once 'config.php';
$movies = $conn->query("SELECT * FROM movies ORDER BY Title") or die($conn->error);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap.min.css">
    <script src="bootstrap.bundle.min.js"></script>
    <title>Document</title>
    <style>
        .card {
            width: 100%;
            height: 100%;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <?php while ($movie = $movies->fetch_assoc()) { ?>
                <div class="col-md-3 mb-2">
                    <div class="card">
                        <div class="card-header">
                            <img src="images/<?= $movie['imdbID'] ?>.jpg" alt="img" class="img-fluid">
                        </div>
                        <div class="card-body">
                            <p>Title: <?= $movie['Title'] ?></p>
                            <p>Genre: <?= $movie['Genre'] ?></p>
                            <p>Actors: <?= $movie['Actors'] ?></p>
                            <p>Available: <?= $movie['available'] ?></p>
                        </div>
                        <div class="card-footer">
                            <?php if ($movie['available'] <= 0) { ?>
                                <button class="form-control bg-danger btn_modal" data-bs-toggle="modal" data-bs-target="#staticBackdrop" value="<?= $movie['_id'] ?>" disabled>Not Available</button>
                            <?php } else { ?>
                                <button class="form-control bg-primary btn_modal" data-bs-toggle="modal" data-bs-target="#staticBackdrop" value="<?= $movie['_id'] ?>">Rent Now!</button>
                            <?php } ?>

                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>

        <!-- modal start -->

        <!-- Modal -->
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <img src="images/tt0470752.jpg" alt="modal_img" class="img-fluid" id="poster">
                            </div>
                            <div class="col-md-6">
                                <form action="save.php" method="post">
                                    <input type="hidden" name="movie_id" id="movie_id">
                                    <input type="hidden" name="available" id="available">
                                    <div class="col">
                                        <label for="fullname">Fullname</label>
                                        <input type="text" class="form-control" id="fullname" name="fullname" required>
                                    </div>
                                    <div class="col mt-2">
                                        <label for="contactNo">Contact Number</label>
                                        <input type="text" class="form-control" id="contactNo" name="contactNo" required>
                                    </div>
                                    <div class="col mt-2">
                                        <button type="submit" class="form-control bg-success text-light">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="jquery-3.6.1.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.btn_modal').click(function() {
                let val = this.value;
                var request = $.ajax({
                    url: "getMovie.php",
                    method: "GET",
                    data: {
                        id: val
                    },
                    dataType: "json"
                });

                request.done(function(msg) {
                    $('#poster').attr('src', 'images/' + msg.imdbID + '.jpg');
                    $('.modal-title').html(msg.Title);
                    $('#movie_id').val(msg._id);
                    $('#available').val(msg.available);
                });

                request.fail(function(jqXHR, textStatus) {
                    alert("Request failed: " + textStatus);
                });
            })

            $('#contactNo').keyup(function() {
                let val = Number(this.value);
                if (val != val) {
                    $(this).val('');
                }
            })
        })
    </script>
</body>

</html>