<div>
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="grid gap-4 md:grid-cols-3">
            <x-card-auth-dashboard />
            <x-card-dashboard :title1="'Insegnanti'" :title2="'Studenti'" :items1="$teachers" :items2="$students" />
            <x-card-dashboard :title1="'Corsi Totali'" :title2="'Corsi Serali'" :items1="$courses"
                :items2="$evening_courses" />
        </div>

        <div class="flex gap-5">
            <x-chart-badge-dashboard :labels="$labels" :data="$data" />
            <x-chart-courses-dashboard  :data="$dataCourses" :labels="$labelsCourses" 
            :backgroundColors="$backgroundColors" :borderColors="$borderColors" />
        </div>

    </div>
</div>