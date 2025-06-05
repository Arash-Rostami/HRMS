<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SMART SALES SERVICE</title>
    @include('components.shop.temp-css')

</head>
<body class="overflow-hidden container mx-auto" style="background:  #202124">
<x-shop.loader />
<x-shop.nav />



<div class="flex items-center justify-center h-screen hidden" id="main">
    <div id="bg">
        <x-shop.bg/>
    </div>
    <div class="flex text-gray-300 p-5 flex-col text-right direction-rtl items-center justify-center">
        <div class="w-full p-4 self-center text-justify" id="text-container">
            <div id="text-head">
                <h1>
                    سلام. با سرویس هوشمند PERSOL هم اکنون می توانید اطلاعات لازم پیرامون محصولات مان را بدست آورید
                    یا از
                    خرید و پشتیبانی آنلاین ما بهره ببرید.
                </h1>
                <h2>
                    در ابتدا محصول مورد نظر را انتخاب کنید:
                </h2>
            </div>

        </div>
        <div class="w-3/4 h-1/2 p-4 text-center border-gray-600 border-b-2 self-center scale-in-center">
            <button class="rounded main-btn p-5 btn-shadow transition duration-300 transform hover:scale-110 m-3">
                چوب و کاغذ
            </button>
            <button class="rounded main-btn p-5 btn-shadow transition duration-300 transform hover:scale-110 m-3">
                مواد شیمیایی
            </button>
            <button class="rounded main-btn p-5 btn-shadow transition duration-300 transform hover:scale-110 m-3">
                مواد معدنی
            </button>
        </div>
        <div class="w-3/4 h-1/4 text-center self-center scale-in-center">

            <button
                class="rounded extra-btn extra-btn-shadow p-5 transition duration-300 transform hover:scale-110 m-3 ">
                درباره ما
            </button>
            <button
                class="rounded extra-btn extra-btn-shadow p-5 transition duration-300 transform hover:scale-110 m-3 ">
                پشتیبانی
                کارشناس
            </button>
            <button
                class="rounded extra-btn extra-btn-shadow p-5 transition duration-300 transform hover:scale-110 m-3 "
                onclick="openNav()">
                سایر لینکها
            </button>

        </div>
    </div>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/TypewriterJS/2.19.0/core.min.js"
        integrity="sha512-t4NGjfaRaGCjmiTGBsiG3w8FCp8ZY7dPlwZAXfeoGPARUT/rt3OP0NpQkblSgZy/2R8vPTXiEcq/zcWIJ8NusQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="{{ asset('/js/tailwindcss.js') }}"></script>

</body>
@include('components.shop.temp-js')


</html>
