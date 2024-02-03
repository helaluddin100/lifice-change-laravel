@extends('master.master')

@section('content')
    <section class="nftmax-adashboard nftmax-show">
        <div class="nftmax-adashboard-left">



            <div class="row support-ticket-main m-0">
                <div class="col-lg-12">
                    <div class="from">
                        <div class="row">
                            <div class="col-12 ">
                                <label for="name" class="form-label"> Name </label>
                                <input type="text" class="form-control" name="name" aria-label="Name">
                            </div>

                        </div>

                        <div class="mb-3">

                            <label for="exampleFormControlInput1" class="form-label">Descriptions</label>
                            <div id="editor"></div>

                        </div>

                        <div class="ticket-btn">
                            <div class="btn-one">
                                <a type="submit">Submit Ticket</a>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <label for="status" class="form-label">Status</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="status" name="status">
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

        </div>


    </section>
@endsection
