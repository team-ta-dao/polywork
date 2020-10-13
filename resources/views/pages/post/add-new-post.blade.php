@extends('master')

@section('title','Add New Post')

@section('head-script')
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="{{ asset('js/job-post/ajax/update-company-card.js') }}"></script>
<script src="{{ asset('js/job-post/ajax/find-tags.js') }}"></script>
@endsection

@section('content')
<main class="h-full overflow-y-auto">
    <div class="container px-6 mx-auto grid">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Add New Post
        </h2>

        <!--Add new Job Post field-->
        <div class="w-full rounded-lg">
            <!--Job Post-->
            <div class="grid grid-cols-3 gap-10 ">
                <div class="w-full col-span-2">
                    <!--Title-->
                    <label for="post-title" class="block text-gray-700 text-md font-bold mb-2">Title</label>
                    <input type="text" class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="post-title">
                    <!--preview url-->
                    <a href="#" class="font-sm text-blue-500 my-2"><strong>preview: </strong> <span id="preview-url">job/tuyen-dung</span> </a>

                    <!--Content-->
                    <label for="job-content" class="block text-gray-700 text-md font-bold mb-2 mt-4">Job Content</label>
                    <div id="job-content" class="bg-white"></div>

                    <!--Require-->
                    <label for="job-require" class="block text-gray-700 text-md font-bold mb-2 mt-4">Job Require</label>
                    <div id="job-require" class="bg-white h-32"></div>

                    <!--Offer-->
                    <label for="job-offer" class="block text-gray-700 text-md font-bold mb-2 mt-4">Job Offer</label>
                    <div class="flex items-center">
                        <div class="w-1/3">
                            <div class="relative" x-data="{openOffer: false}">
                                <button @click="openOffer = true" class="py-2 px-4 bg-gray-200 w-full">Choose Offer</button>
                                <ul x-show="openOffer" @click.away="openOffer = false" class="z-10 absolute t-0 bg-white shadow w-full h-64 overflow-scroll">
                                    @foreach($jobBenefit as $item)
                                    <li class="p-2">
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" class="form-checkbox h-5 w-5 text-gray-600" value="{{ $item->id }}"><span class="ml-2 text-gray-700">{{ $item->name }}</span>
                                        </label>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="w-2/3">
                            <div id="offer-list" class="bg-white w-2/3"></div>
                        </div>
                    </div>


                    <!--Title-->
                    <label for="job-salary" class="block text-gray-700 text-md font-bold mb-2">Salary</label>
                    <div class="grid grid-cols-2 gap-6">
                        <div class="flex border">
                            <input type="text" class="appearance-none rounded-l w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="job-salary">
                            <select name="currency" id="currency" class="appearance-none rounded-r py-2 px-3 text-gray-700 bg-gray-200 leading-tight focus:outline-none focus:shadow-outline">
                                <option value="vnd">VND</option>
                                <option value="usd">USD</option>
                            </select>
                        </div>

                        <div class="w-full">
                            <label class="inline-flex items-center mt-3">
                                <input type="checkbox" class="form-checkbox h-5 w-5 text-blue-600" checked><span class="ml-2 text-gray-700">Show Salary</span>
                            </label>
                        </div>
                    </div>

                    <!--Job Location-->
                    <label for="job-location" class="block text-gray-700 text-md font-bold mb-2">Job Location</label>
                    <div class="flex items-center border w-full bg-gray-200 rounded-lg">
                        <ion-icon name="location" class="w-5 h-5 mx-4"></ion-icon>
                        <input type="text" class="appearance-none rounded-r py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline w-full">
                    </div>

                    <div class="grid grid-cols-3 gap-4">

                    </div>
                </div>

                <div class="w-full h-full">
                    <!--Company Cart-->
                    <div id="company" class="">
                        <div class="bg-white pb-6 w-full justify-center items-center overflow-hidden md:max-w-sm rounded-lg shadow-md mx-auto">
                            <div class="relative h-40">
                                <img id="cover-img" class="absolute h-full w-full object-cover" src="https://images.unsplash.com/photo-1448932133140-b4045783ed9e?ixlib=rb-1.2.1&auto=format&fit=crop&w=400&q=80">
                            </div>
                            <div class="relative shadow mx-auto h-24 w-24 -my-12 border-white rounded-full overflow-hidden border-4">
                                <img id="avatar" class="object-cover w-full h-full" src="https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcS_J-u4_EEo5W3jDFYBFpaFiRO42ZMRZFAk4Q&usqp=CAU">
                            </div>
                            <div class="mt-16">
                                <!-- <h1 class="text-lg text-center font-semibold">
                                    
                                </h1> -->
                                <div class="flex justify-center items-center">
                                    <select name="slt-company" id="slt-company" class="block appearance-none w-2/3 bg-gray-100 border border-gray-100 text-gray-500 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" onchange="updateCard(this)">
                                        @foreach($company as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <p id="desc" class="text-sm text-gray-600 text-center mt-2">
                                    13 tuyển dụng tháng này
                                </p>
                            </div>
                            <div class="mt-6 pt-3 flex flex-wrap mx-6 border-t" id="">
                                <div id="job-cat" class="text-xs mr-2 my-1 uppercase tracking-wider border px-2 text-orange-600 border-orange-500 hover:bg-orange-500 hover:text-orange-100 cursor-default">
                                    User experience
                                </div>

                            </div>
                        </div>
                    </div>

                    <!--Job Post Category-->
                    <div id="post-category" class="bg-white pb-6 w-full justify-center items-center overflow-hidden md:max-w-sm rounded-lg shadow-md mx-auto my-4 px-4 py-2">
                        <h2 class="font-semibold text-lg">Categories</h2>

                        <ul id="post-category max-w-32 overflow-scroll">
                            @foreach($category as $item)
                            <li class="p-2">
                                <label class="inline-flex items-center">
                                    <input type="checkbox" class="form-checkbox h-5 w-5 text-gray-600" value="{{ $item->id }}"><span class="ml-2 text-gray-700">{{ $item->name }}</span>
                                </label>
                            </li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Employer Need-->
                    <div id="employer" class="bg-white pb-6 w-full justify-center items-center overflow-hidden md:max-w-sm rounded-lg shadow-md mx-auto my-4 px-4 py-2">
                        <h2 class="font-semibold text-lg mb-2">Employer need</h2>

                        <input type="number" name="employer-need" id="employer-need" class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>

                    <!-- Job Level -->
                    <div id="" class="bg-white pb-6 w-full justify-center items-center overflow-hidden md:max-w-sm rounded-lg shadow-md mx-auto my-4 px-4 py-2">
                        <h2 class="font-semibold text-lg mb-2">Job Level</h2>

                        <ul id="job-level">
                            @foreach($jobLevel as $item)
                            <li class="p-2">
                                <label class="inline-flex items-center">
                                    <input type="checkbox" class="form-checkbox h-5 w-5 text-gray-600" value="{{ $item->id }}"><span class="ml-2 text-gray-700">{{ $item->name }}</span>
                                </label>
                            </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="bg-white pb-6 w-full justify-center items-center overflow-hidden md:max-w-sm rounded-lg shadow-md mx-auto my-4 px-4 py-2" id="tags">
                        <h2 class="font-semibold text-lg mb-2">Tags</h2>
                        <div class="">
                            <input type="text" name="tags-search" id="tags-search" onkeyup="findTags(this)" class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <ul id="tag-search-result" class="absolute max-h-32 hidden">
                                <!--Result go here-->
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="my-6"></div>
</main>

@endsection

@section('footer-script')
<!-- Include the Quill library -->
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

<script>
    var toolbarOption = [
        [{
            'header': [1, 2, 3, 4, 5, 6, false]
        }],
        [{
            'font': []
        }],
        ['bold', 'italic', 'underline', 'strike'], // toggled buttons
        ['blockquote', 'code-block'],

        // [{
        //     'header': 1
        // }, {
        //     'header': 2
        // }], // custom button values
        [{
            'list': 'ordered'
        }, {
            'list': 'bullet'
        }, {
            'align': []
        }],

        [{
            'indent': '-1'
        }, {
            'indent': '+1'
        }], // outdent/indent
        [{
            'direction': 'rtl'
        }], // text direction
        [{
            'color': []
        }, {
            'background': []
        }],
        ['link', 'image', 'video', 'formula']
    ];

    var editor = ['#job-content', '#job-require'];

    // for (let index = 0; index < editor.length; index++) {
    //     const element = editor[index];
    //     var editor = new Quill(element, {
    //         modules:{
    //             toolbar: toolbarOption
    //         },
    //         theme: 'snow'
    //     });
    // }

    var postContent = new Quill('#job-content', {
        modules: {
            toolbar: toolbarOption
        },
        theme: 'snow'
    });
    var postContent = new Quill('#job-require', {
        theme: 'snow'
    });
</script>
@endsection