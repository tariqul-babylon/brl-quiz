@extends('front.layouts.app')

@section('content')
    <div id="top-screen" class="d-none">
        <img src="{{ asset('front') }}/img/leaderboard.png" alt="">
    </div>
    <div id="bottom-screen" class="d-none2">
        <section id="leader-title">
            <div class="container">
                <div class="content">
                    <img id="winnerIcon" src="{{ asset('front') }}/img/crown.png" alt="">
                    <h2 class="title">Leader Board</h2>
                    <div class="tagline">
                        Quiz for Ahsanullah University of Science and Technology
                    </div> 
                    <a href="" class="btn btn-light btn-sm mt-2">Back To Exam List</a>
                </div>
            </div>
        </section>

        <section id="winners">
            <div class="container">
                <div class="content">
                    @foreach (range(1, 20) as $item)
                        <div class="winner">
                            <div class="left">
                                <div class="sl">
                                    @if ($loop->iteration <= 3)
                                        <img src="{{ asset('front') }}/img/{{ $loop->iteration }}.png" alt="">
                                    @else
                                        <div class="slno">
                                            {{ $loop->iteration }}
                                        </div>
                                    @endif
                                </div>
                                <div class="identity">
                                    <div class="digit">Tahsin Mostofa</div>
                                    <div class="label">thsn*******@gmail.com</div>
                                </div>
                            </div>
                            <div class="start-at">
                                <div class="digit">03:00:04</div>
                                <div class="label">Start At</div>
                            </div>
                            <div class="score">
                                <div class="digit">19</div>
                                <div class="label">Score</div>
                            </div>

                            <div class="duration text-end">
                                <div class="digit">29:03</div>
                                <div class="label">Duration</div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </section>
    </div>

   
@endsection
