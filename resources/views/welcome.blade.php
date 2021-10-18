<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Icon Search</title>
    <script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qs/6.10.1/qs.min.js" integrity="sha512-aTKlYRb1QfU1jlF3k+aS4AqTpnTXci4R79mkdie/bp6Xm51O5O3ESAYhvg6zoicj/PD6VYY0XrYwsWLcvGiKZQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@100;300;400;700&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Lato', sans-serif;
        }
    </style>
</head>

<body class="">
    <div id="app">
        <div class="h-96 bg-indigo-700 flex flex-col justify-center items-center">
            <h3 class="text-white text-center text-3xl sm:text-4xl drop-shadow-sm font-bold"> Over 3.6 Million+ Design Assets </h3>
            <p class="text-center px-16 lg:px-96 text-gray-200">
                Curated SVGs, Vector Icons, Illustrations, 3D graphics, and Lottie Animations.
                Over 4000+ new assets added every day. Integrated plugins, tools, editors, and more
            </p>
            <input v-model="searchText" type="text" class="w-11/12 max-w-2xl px-4 py-2 rounded mt-5 outline-none hover:shadow-lg ring-0 ring-indigo-600 hover:ring-1 focus:ring-1" />
            <button v-on:click="search" type="button" class="bg-indigo-600 mt-4 inline-flex items-center px-4 py-2 border border-transparent text-base leading-6 font-medium rounded-md text-white bg-rose-600 hover:bg-rose-500 focus:border-rose-700 active:bg-rose-700 transition ease-in-out duration-150">
                <svg v-if="isLoading" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                !{ isLoading ? 'Processing' : 'Search' }!
            </button>
        </div>
        <div class="flex flex-col px-10 py-5" v-if="results.length > 0">
            <p class="pb-4" v-if="searched">!{total}! !{ searched }! results</p>
            <p class="pb-4" v-if="!searched">Showing most recent</p>

            <div class="flex flex-row flex-wrap gap-2">
                <div v-for="result in results" :key="result.id" class="w-28 h-28 my-4 hover:border rounded transition-all px-2 text-center" v-for="result in results">
                    <img :src="result.image" alt="" srcset="" />
                    <p>!{result.name}!</p>
                </div>
            </div>
        </div>
        <div class="flex flex-col px-10 py-5" v-if="results.length == 0">
            <p>
                !{isLoading ? '' : 'Nothing here!'}!
            </p>
        </div>
    </div>

</body>
<script>
    var app = new Vue({
        el: '#app',
        delimiters: ['!{', '}!'],
        data: {
            searchText: '',
            results: [],
            isLoading: false,
            searched: '',
            total: 0,
            aggs: []
        },
        mounted: function() {
            this.searchText = ""
            this.search() //method1 will execute at pageload
        },
        methods: {
            search: async function() {
                this.isLoading = true
                this.results = []
                try {
                    this.searched = this.searchText
                    const query = Qs.stringify({
                        query: this.searchText
                    })
                    const response = await fetch(`/api/search?${query}`, {
                        method: "GET",
                        headers: {
                            'content-type': 'application/json',
                            'Authorization': 'Bearer {{$token}}'
                        }
                    })
                    const json = await response.json()
                    console.log(json);
                    this.results = json.data.items;
                    this.total = json.data.total;
                    this.aggs = json.data.aggs;
                } catch (error) {

                }
                this.isLoading = false
            }
        }
    })
</script>

</html>