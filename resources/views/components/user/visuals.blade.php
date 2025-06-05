<div class="mx-auto">
    <div class="my-8 md:ml-4 ">
        <h6 class="text-justify">
            Explore the statistics of PERSOL for getting to know your workplace better.
        </h6>
        <div class="flex flex-row-reverse">
            <button title="Back to the user panel"
                    @click="window.location.href = '{{ route('user.panel.analytics') }}'"
                    class="bg-main-mode hover:opacity-50 py-1 px-2 rounded">
                <i class="fas fa-arrow-left normal-color text-white"></i>
            </button>
        </div>
    </div>
    {{--                FIRST ROW--}}
    <div class="card-job links-thumbnails px-5 py-12">
        <div class="flex flex-col md:flex-row gap-4">
            <div class="w-2/3 md:w-1/5 mx-auto mb-4 md:mb-0">
                <canvas id="genderChart"></canvas>
            </div>
            <div class="w-full md:w-1/3 mx-auto my-auto">
                <canvas id="educationExperienceChart" height="200"></canvas>
            </div>
            <div class="w-2/3 md:w-1/5 mx-auto mt-4 md:mb-0">
                <canvas id="employmentTypeChart"></canvas>
            </div>
        </div>
    </div>
    {{--                SECOND ROW--}}
    <div class="card-job links-thumbnails px-5 py-12">
        <div class="flex flex-col md:flex-row gap-4 mb-4">
            <div class="w-full md:w-1/3 mx-auto mb-2 md:my-auto">
                <canvas id="genderDistribution" height="220"></canvas>
            </div>
            <div class="w-full md:w-1/3 mx-auto mt-2 md:my-auto">
                <canvas id="ageDistributionChart" height="220"></canvas>
            </div>
        </div>
    </div>
    {{--                THIRD ROW--}}
    <div class="card-job links-thumbnails px-0 pt-6">
        <div class="flex flex-col md:flex-row gap-4 mt-4">
            <div class="w-full md:w-1/2 mx-auto">
                <canvas id="departmentDistributionChart"></canvas>
            </div>
            <div class="w-full md:w-1/2 mx-auto my-auto">
                <canvas id="departmentAverageWorkingHours"></canvas>
            </div>
        </div>
    </div>
</div>

