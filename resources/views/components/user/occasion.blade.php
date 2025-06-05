@if ( isSpecialDay('birthdate'))
    @php
        $birthdayQuotes = [
        "Wishing you a day filled with laughter and joy.",
        "May your day be as special as you are.",
        "Another year, another reason to celebrate!",
        "May this year be the best one yet.",
        "Today is all about you. Enjoy every moment.",
        "Wishing you health, happiness, and success in the year ahead.",
        "Embrace the new age with grace and positivity.",
        "Life is a journey, and today is a new beginning.",
        "Birthdays are nature's way of telling us to eat more cake!",
        "Celebrate the gift of life with gratitude and love.",
        "A year older, a year wiser.",
        "You are never too old to set another goal or dream a new dream.",
        "Age is merely the number of years the world has been enjoying you.",
        "In the end, it's not the years in your life that count. It's the life in your years.",
        "Every year on your birthday, you get a chance to start new.",
        "A birthday is the first day of another 365-day journey around the sun. Enjoy the trip!",
        "Growing older is a privilege denied to many. Celebrate it!",
        "Youth is a gift of nature, but age is a work of art.",
        "Remember, age is merely the number of years the world has been enjoying you!",
];
    @endphp
    <x-user.occasion-confetti/>

    <x-user.occasion-modal title="Happy Birthday {{ auth()->user()->forename }}!"
                           message="{{ $birthdayQuotes[array_rand($birthdayQuotes)] }}"></x-user.occasion-modal>

    {{--    DO NOT SHOW THE HB MESSAGE FOR AT LEAST 8 HOURS--}}
    @php cache()->put('birthdate'.auth()->id(), 'The birthday message was shown :)', now()->addHours(8)); @endphp
@endif

@if ( isSpecialDay('start_date'))
    @php
        $startDateQuotes = [
          "Congratulations on reaching another milestone in your career!",
          "Here's to a year of growth, learning, and success.",
          "Your dedication and hard work have made a significant impact on our team.",
          "Cheers to a year filled with achievements and new opportunities.",
          "Thank you for your commitment and contributions to our company.",
          "Your journey with us has been nothing short of remarkable.",
          "May this anniversary mark the beginning of even greater accomplishments.",
          "Your professionalism and dedication inspire us all.",
          "A year of dedication, teamwork, and excellence. Well done!",
          "Your passion for what you do shines through in your work.",
          "May your career continue to thrive and prosper with each passing year.",
          "Your journey with us has been a fantastic adventure. Here's to many more!",
          "Congratulations on achieving another successful year in your career.",
          "Your hard work and commitment are truly appreciated.",
          "Your contributions have made our team stronger and more successful.",
          "May this anniversary be a stepping stone to even greater achievements.",
          "Your enthusiasm and dedication continue to inspire us.",
          "One year down, many more to go. Your future here is bright!",
          "Thank you for your dedication and passion in everything you do.",
          "Your journey with us is a testament to your outstanding skills and commitment.",
];
    @endphp
    <x-user.occasion-confetti/>

    <x-user.occasion-modal title="Happy Work Anniversary {{ auth()->user()->forename }}!"
                           message="{{ $startDateQuotes[array_rand($startDateQuotes)] }}"></x-user.occasion-modal>

    {{--    DO NOT SHOW THE WA MESSAGE FOR AT LEAST 8 HOURS--}}
    @php cache()->put('start_date'.auth()->id(), "The start date message was shown :)", now()->addHours(8)); @endphp
@endif
