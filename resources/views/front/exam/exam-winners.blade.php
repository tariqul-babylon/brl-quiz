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
                        {{ $exam->title }}
                    </div>
                    <a href="" class="btn btn-light btn-sm mt-2">Back To Exam List</a>
                </div>
            </div>
        </section>

        <section id="winners">
            <div class="container">
                <div class="content">
                    @foreach ($winners as $item)
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
                                    @php
                                        $contact = $item->contact;

                                        if (filter_var($contact, FILTER_VALIDATE_EMAIL)) {
                                            // Mask email (e.g., thsn*******@gmail.com)
                                            $emailParts = explode('@', $contact);
                                            $namePart = $emailParts[0];
                                            $domainPart = $emailParts[1];
                                            $maskedName = substr($namePart, 0, 4) . str_repeat('*', max(1, strlen($namePart) - 4));
                                            $maskedContact = $maskedName . '@' . $domainPart;
                                        } else {
                                            // Mask phone number (e.g., 98******45)
                                            $maskedContact = substr($contact, 0, 2) . str_repeat('*', strlen($contact) - 4) . substr($contact, -2);
                                        }
                                    @endphp
                                    <div class="digit">{{ $item->name }}</div>
                                    <div class="label">{{ $maskedContact }}</div>
                                </div>
                            </div>
                            <div class="start-at">
                                <div class="digit">{{ \Carbon\Carbon::parse($item->join_at)->format('H:i:s') }}</div>
                                <div class="label">Start At</div>
                            </div>
                            <div class="score">
                                <div class="digit">{{ $item->final_obtained_mark }}</div>
                                <div class="label">Score</div>
                            </div>

                            <div class="duration text-end">
                                <div class="digit">{{ \Carbon\CarbonInterval::createFromFormat('H:i:s.u', $item->duration)->format('%H:%I:%S') }}</div>
                                <div class="label">Duration</div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </section>
    </div>


@endsection
