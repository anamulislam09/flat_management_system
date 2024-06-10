@extends('layouts.admin')
@section('admin_content')
    <style>
        #cont {
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 8px;
        }

        .son {
            position: relative;
        }

        #control {
            display: flex;
            justify-content: space-around;
            background: HoneyDew;
            opacity: 0.7;
            color: #fff;
            text-align: center;
        }

        #snap {
            background-color: dimgray;
        }

        #retake {
            background-color: coral;
        }

        #close {
            background-color: lightcoral;
        }

        .hov {
            opacity: .8;
            transition: all .5s;
        }

        .hov:hover {
            opacity: 1;
            font-weight: bolder;
        }

        #video {
            width: 150px;
            height: auto;
        }

        #canvas {
            width: 150px;
            height: auto;
        }

        .btn-block+.btn-block {
            margin-top: 0px !important;
        }

        @media (max-width: 600px) {
            #cont {
                flex-direction: column;
                display: flex;
                justify-content: space-between;
            }

            #video,
            #canvas {
                width: 100px;
            }

            .text {
                font-size: 13px !important;
            }
        }
    </style>
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text">Guest</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item text"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active text">Guest</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card card-primary">
                            <div class="card-header p-1">
                                <h3 class="card-title">
                                    <a href="{{ route('guestBook.index') }}"
                                        class="btn btn-light shadow rounded m-0 text-dark text">
                                        <span>See All</span>
                                    </a>
                                </h3>
                            </div>
                            <form action="{{ route('guestBook.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-sm-12 col-md-6 col-lg-6 mb-0">
                                            <label class="text">Guest Name</label>
                                            <input class="form-control text" type="text" name="name" id="name"
                                                placeholder="Enter Guest Name" required>
                                        </div>
                                        <div class="form-group col-sm-12 col-md-6 col-lg-6">
                                            <label class="text">Phone</label>
                                            <input class="form-control text" type="text" name="phone" id="phone"
                                                placeholder="Enter valid phone" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-sm-12 col-md-6 col-lg-6">
                                            <label class="text">Address</label>
                                            <input class="form-control text" type="text" name="address" id="address"
                                                placeholder="Enter Address">
                                        </div>
                                        <div class="form-group col-sm-12 col-md-6 col-lg-6">
                                            <label class="text">Where will you go?</label>
                                            <select name="flat_id" id="" class="form-control text" required>
                                                <option value="" selected disabled>Select Flat</option>
                                                @foreach ($flats as $flat)
                                                    <option value="{{ $flat->flat_id }}">{{ $flat->flat_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-sm-12 col-md-6 col-lg-6">
                                            <label class="text">Purpose</label>
                                            <textarea name="purpose" id="" class="form-control text" placeholder="Enter Purpose"></textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="container-fluid" id="camcam">
                                            <a class="btn btn-primary text-white text" id="open">Open cam</a>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div id="wrap">
                                                        <div id="cont">
                                                            <div id="vid" class="son">
                                                                <video id="video" autoplay></video>
                                                            </div>
                                                            <div id="capture" class="son">
                                                                <canvas id="canvas"></canvas>
                                                                <canvas id="blank" style="display:none;"></canvas>
                                                            </div>
                                                        </div>
                                                        <div id="control" style="display: none;">
                                                            <a id="retake" class="btn btn-block hov text"><i
                                                                    class="fas fa-sync-alt"></i> Retake</a>
                                                            <a id="snap" class="btn btn-block hov text"><i
                                                                    class="fas fa-camera"></i> Snap</a>
                                                            <a id="close" class="btn btn-block text hov"><i
                                                                    class="fas fa-times"></i> Close</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- end row -->
                                    <!-- Hidden input to store the captured image data -->
                                    <input type="hidden" name="image_data" id="image_data">
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary text">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            let video = document.getElementById('video');
            let canvas = document.getElementById('canvas');
            let context = canvas.getContext('2d');
            let imageDataInput = document.getElementById('image_data');
            let stream;

            async function opencam() {
                try {
                    console.log('Requesting camera access...');
                    stream = await navigator.mediaDevices.getUserMedia({
                        video: true
                    });
                    console.log('Camera access granted.');
                    video.srcObject = stream;
                    video.play();
                    document.getElementById('control').style.display = 'flex'; // Show control buttons
                } catch (error) {
                    console.error('Error accessing camera:', error);
                    alert(error.name + ": " + error.message);
                }
            }

            function closecam() {
                console.log('Closing camera...');
                video.pause();
                if (video.srcObject) {
                    let tracks = video.srcObject.getTracks();
                    tracks.forEach(track => track.stop());
                    video.srcObject = null;
                }
                document.getElementById('control').style.display = 'none';
            }

            document.getElementById('open').addEventListener('click', opencam);
            document.getElementById('close').addEventListener('click', closecam);

            document.getElementById('snap').addEventListener('click', () => {
                // Adjust canvas size and draw image maintaining aspect ratio
                const aspectRatio = video.videoWidth / video.videoHeight;
                const width = 150;
                const height = width / aspectRatio;

                canvas.width = width;
                canvas.height = height;

                context.drawImage(video, 0, 0, width, height);
                document.getElementById('vid').style.zIndex = '20';
                document.getElementById('capture').style.zIndex = '30';
                document.getElementById('control').style.zIndex = '40'; // Ensure control remains visible

                // Get the image data URL and set it as the value of the hidden input
                const imageDataURL = canvas.toDataURL('image/png');
                imageDataInput.value = imageDataURL;
            });

            document.getElementById('retake').addEventListener('click', () => {
                document.getElementById('vid').style.zIndex = '30';
                document.getElementById('capture').style.zIndex = '20';
                document.getElementById('control').style.zIndex = '40'; // Ensure control remains visible
            });
        });
    </script>
@endsection
