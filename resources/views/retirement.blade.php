<x-app-layout>
    <x-slot name="header">
        <div class="shrink-0 flex items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Retirement') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <script type="text/javascript" src="instascan.min.js"></script>
            @if (Auth::user()->privilege->privilege_grade >= 2)
                <div id="pistachazo" class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="flex mt-8 mb-8 justify-center">
                        <video id="previewVideoCam"></video>
                    </div>
                </div>

                <script type="text/javascript">
                    let scanner = new Instascan.Scanner({ video: document.getElementById('previewVideoCam') });
                    scanner.addListener('scan', function (content) {
                        fetch(content)
                            .then(response => response.text())
                            .then(html => console.log(html))
                            .catch(error => console.log('Ocurrió un error:', error));

                        location.reload()
                    });
                    Instascan.Camera.getCameras().then(function (cameras) {
                        if (cameras.length > 0) {
                        cameras.forEach(element => {
                            scanner.start(element);
                        });
                        } else {
                        console.error('No cameras found.');
                        }
                    }).catch(function (e) {
                        console.error(e);
                    });
                </script>

                <div class="bg-white dark:bg-gray-800 mt-8 overflow-hidden shadow-xl sm:rounded-lg">
                    <livewire:today-retirements />
                </div>
            @endif
            @if (Auth::user()->privilege->privilege_grade == 1)
                <div class="bg-white dark:bg-white mt-8 overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="flex mt-8 mb-8 justify-center">
                        <livewire:retirement-qr />
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
