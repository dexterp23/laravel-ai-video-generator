<a href="#" onClick="rusure(); return false;" {{ $attributes->merge(['class' => 'inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
    <script>
        function rusure(){
            question = confirm("{{__('Are you sure you want to delete?')}}")
            if (question !="0"){
                top.location = "{{$route}}"
            }
        }
    </script>
</a>
