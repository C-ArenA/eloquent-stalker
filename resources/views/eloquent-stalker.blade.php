<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Eloquent Stalker</title>
    {{ Vite::useHotFile('vendor/eloquent-stalker/eloquent-stalker.hot')
        ->useBuildDirectory("dist")
        ->withEntryPoints(['resources/css/app.css', 'resources/js/app.js']) }}
</head>

<body>
    <div class="drawer md:drawer-open">
        <input id="my-drawer-2" type="checkbox" class="drawer-toggle" />
        <div class="drawer-content flex flex-col items-center justify-center">
            <!-- Page content here -->
            @if ($selectedModel)
                <div class="flex items-center justify-between">
                    <div class="p-3 border">{{ $selectedModel }}</div>
                    <div class="min-w-12">
                        <hr class="border-t-2 border-t-primary border-b-2 border-b-transparent">
                    </div>
                    <div class="h-full pt-[23px] py-[25px]">
                        <div class="h-full border-r-2 border-r-primary"></div>
                    </div>
                    <div class="flex flex-col items-start gap-6 justify-between">
                        @foreach ($relationships[$selectedModel] as $relationship)
                            <div class="flex items-center">
                                <div class="divider divider-primary min-w-72">
                                    <div class="indicator">
                                        <span
                                            class="indicator-item indicator-center badge badge-secondary text-xs">{{ $relationship['type'] }}</span>
                                        <p class="pt-2">{{ $relationship['name'] }}
                                        </p>
                                    </div>
                                </div>
                                <div class="p-3 border">{{ $relationship['model'] }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
            <label for="my-drawer-2" class="btn btn-primary drawer-button md:hidden">Modelos</label>
        </div>
        <div class="drawer-side">
            <label for="my-drawer-2" aria-label="close sidebar" class="drawer-overlay"></label>
            <ul class="menu bg-base-200 text-base-content min-h-full w-80 p-4">
                <!-- Sidebar content here -->
                @foreach ($models as $model)
                    <li>
                        <a
                            href="{{ route('eloquent-stalker.index', ['selectedModel' => $model]) }}">{{ $model }}</a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</body>

</html>
