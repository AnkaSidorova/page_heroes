<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Laravel</title>

    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="{{ asset('js/app.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/dropzone.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.0/min/dropzone.min.css">
</head>

<body>
    <section class="container-fluid bg-dark pt-5 pb-3" id="slider">
        <div class="container p-0 text-light">
            <div class="text-center pb-5 header">
                <h2 class="text-light">Моя <span>супер команда</span></h2>
            </div>
            <div class="container p-0">

                <div class="swiper-container">
                    <div class="swiper-wrapper">
                        @foreach($users as $user)
                        <div class="swiper-slide" ata-swiper-autoplay="2000">
                            <div class="text-center">
                                <img src="/uploads/images/{{ $user->image }}" class="img-fluid mx-auto d-block" alt="img1">
                                <div class="card-body">
                                    <h5 class="card-title p-0 m-0 text-light"> {{ $user->name }} </h5>
                                    <p class="card-text text-secondary">{{ $user->descr }}</p>
                                    <p class="card-text text-secondary p-0 m-0">Дата вступления в команду:</p>
                                    <p class="card-text text-secondary">{{ $user->created_at }}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="swiper-pagination pt-3 position-relative"></div>
                </div>

            </div>
        </div>
    </section>
    <section class="container py-5" id="form">
        <div class="text-center pb-5 header">
            <h2 class="text-dark">Добавь своего <span>героя</span></h2>
        </div>
        <div class="row">
            <div class="col-12 col-md-3"></div>
            <div class="col col-md-6">
                <form action="{{ route('form.data') }}" name="demoform" id="demoform" method="POST" class="dropzone border-0 bg-light" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <div class="row">
                            <div class="col-12 col-md-6  mb-3 mb-md-0">
                                <input type="hidden" class="userid" name="userid" id="userid" value="">

                                <label for="name">Имя<span>*</span></label>
                                <input type="text" name="name" id="name" placeholder="Имя" class="form-control" required>
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="descr">Титул<span>*</span></label>
                                <input type="text" class="form-control" placeholder="Титул" id="descr" name="descr" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="decr">Фото<span>*</span></label>
                        <div id="dropzoneDragArea" class="dropzone dz-default dz-message dropzoneDragArea mt-0"></div>
                        <div class="dropzone-previews"></div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn float-right" id="button_prinyt" class="append-slide">Принять</button>
                    </div>
                </form>
            </div>
            <div class="col-12 col-md-3"></div>
        </div>
    </section>
    <section class="container-fluid py-4 bg-dark" id="footer">
        <div class="container text-light">
            <div class="row">
                <div class="col-12 col-md-6 text-uppercase text-secondary copiright text-center text-md-left mb-3 mb-md-0">All rights reserved. copiright &copy; <span class="text-light">ckdigital</span></div>
                <div class="col-12 col-md-6 text-center text-md-right block_network">
                    <a href="#">
                        <img src="{{ asset('img/facebook.svg') }}" alt="" class="networks">
                    </a>
                    <a href="#">
                        <img src="{{ asset('img/google-plus.svg') }}" alt="" class="networks">
                    </a>
                    <a href="#">
                        <img src="{{ asset('img/linkedin.svg') }}" alt="" class="networks">
                    </a>
                    <a href="#">
                        <img src="{{ asset('img/twitter.svg') }}" alt="" class="networks">
                    </a>
                </div>
            </div>
        </div>
    </section>

    <script>
        Dropzone.autoDiscover = false;
        let token = $('meta[name="csrf-token"]').attr('content');
        $(function() {
            var myDropzone = new Dropzone("div#dropzoneDragArea", {
                paramName: "file",
                url: "{{ url('/storeimgae') }}",
                previewsContainer: 'div.dropzone-previews',
                addRemoveLinks: true,
                autoProcessQueue: false,
                uploadMultiple: false,
                parallelUploads: 1,
                maxFiles: 1,
                params: {
                    _token: token
                },
                init: function() {
                    var myDropzone = this;
                    // код отправки формы 
                    $("form[name='demoform']").submit(function(event) {
                        // не отправлять форму, получение url и генерация токена
                        event.preventDefault();
                        URL = $("#demoform").attr('action');
                        formData = $('#demoform').serialize();
                        $.ajax({
                            type: 'POST',
                            url: URL,
                            data: formData,
                            success: function(result) {
                                if (result.status == "success") {
                                    var userid = result.user_id;
                                    // вставка айди пользователя в скрытое поле ввода
                                    $("#userid").val(userid);
                                    myDropzone.processQueue();
                                } else {
                                    console.log("error");
                                }
                            }
                        }).done(function(result) {
                            // $('.swiper-wrapper').append('<div class="swiper-slide">' + result.user_name + '"</div>')
                        });
                    });
                    // срабатывает при отправке изображения
                    this.on('sending', function(file, xhr, formData) {
                        let userid = document.getElementById('userid').value;
                        formData.append('userid', userid);
                    });

                    // очистка формы и дропзоны
                    this.on("success", function(file, response) {
                        $('#demoform')[0].reset();
                        $('.dropzone-previews').empty();
                    });
                }
            });
        });
    </script>
</body>

</html>