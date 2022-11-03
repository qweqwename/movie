@php($nameModalIdRandom = Str::random(40))
@php($nameModalIdRandomButton = Str::random(40))

@if($modal = session()->pull('modal'))
    <div class="modal" id="a{{$nameModalIdRandom}}" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-status bg-success"></div>
                <div class="modal-body text-center py-4">
                    <!-- Download SVG icon from http://tabler-icons.io/i/circle-check -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-green icon-lg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="9" /><path d="M9 12l2 2l4 -4" /></svg>
                    <h3>{{$modal->title}}</h3>
                    <div class="text-muted">{!! $modal->content !!}</div>
                </div>
                <div class="modal-footer">
                    <div class="w-100">
                        <div class="row">
                            <div class="col">
                                <button class="btn w-100" data-bs-dismiss="modal">
                                    {{__('Ок')}}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <a style="display:none" id="a{{$nameModalIdRandomButton}}" class="btn" data-bs-toggle="modal" data-bs-target="#a{{$nameModalIdRandom}}"></a>

    <script>
        window.addEventListener('DOMContentLoaded', (event) => {
            document.querySelector('#a{{$nameModalIdRandomButton}}').click();

            window.addEventListener("keypress", function(event) {
                if (event.key === "Enter") {
                    document.querySelector('.btn-close').click();
                }
            });

        });
    </script>
@endif


