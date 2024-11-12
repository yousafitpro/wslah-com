     @php($languages_array = getAllLanguages(true))
     @extends('layouts.app', ['languages_array' => $languages_array])
     @section('title', __('system.environment.menu'))
     @section('content')
     <div class="row">

         <div class="col-xl-12 col-sm-12">
             <div class="card">
                 <div class="card-header">

                     <div class="row">
                         <div class="col-md-6 col-xl-6">
                             <h4 class="card-title">{{ __('system.environment.menu') }}</h4>
                             <div class="page-title-box pb-0 d-sm-flex">
                                 <div class="page-title-right">
                                     <ol class="breadcrumb m-0">
                                         <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('system.dashboard.menu') }}</a></li>
                                         <li class="breadcrumb-item active">{{ __('system.environment.menu') }}</li>
                                     </ol>
                                 </div>
                             </div>
                         </div>

                         <div class="col-md-6 col-xl-6 text-end add-new-btn-parent">

                         </div>
                     </div>
                 </div>
                 <div class="card-body">
                     <div class="row d-none">
                         <div class="col-6 mt-1 mb-5">
                             <a href="{{route('restaurant.instagram.login')}}" class="btn btn-primary @if(!empty($row->instagram_token))  @endif">Authorize Instagram</a>
                         </div>
                     </div>
                     <form autocomplete="off" novalidate="" action="{{ route('restaurant.environment.setting.updateRestaurant') }}" id="pristine-valid" method="post" enctype="multipart/form-data">
                         @method('put')
                         @csrf
                         @include('restaurant.settings.fields')
                         <div class="row">
                             <div class="col-12 mt-3">

                                 <button class="btn btn-primary" type="submit">{{ __('system.crud.save') }}</button>
                             </div>
                         </div>


                     </form>
                 </div>
                 <!-- end card -->
             </div>
         </div>
     </div>
     @endsection
     @push('third_party_stylesheets')
     <style>
        .logo-option {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
            margin: 0px;
            border: 1px solid #eee;
            padding: 25px;
        }

        .logo-option img {
            display: flex;
            padding: 5px;
        }

         .logo-option:last-child {
             margin-right: 0;
         }

         .logo-option input[type="radio"] {
             width: 20px;
             height: 20px;
         }
     </style>
     @push('third_party_scripts')
     <script>
         $(document).ready(function() {
             function toggleDivs() {
                 var isAvailable = $('#is_on_off').prop('checked');
                 if (isAvailable) {
                     $('.is_title').show();

                 } else {
                     $('.is_title').hide();

                 }
             }
             toggleDivs();
             $('#is_on_off').on('change', function() {
                 toggleDivs();
             });
         });
     </script>

<script>
    $(document).ready(function () {
        // Get the initially selected value
        var initialSelectedLogoUrl = $('#logoSelect').data('sel');

        // alert(initialSelectedLogoUrl);

        // Update the image source
        $('#selectedLogo').attr('src', initialSelectedLogoUrl);

        // Check if the initially selected logo is the white logo
        if (initialSelectedLogoUrl === "{{ asset('assets/images/wslah_white.png') }}") {
            // Set the background to black
            $('#selectedLogo').css('background', '#000');
        }

        // Add an event listener to the dropdown using jQuery
        $('#logoSelect').change(function () {
            // Get the selected value
            var selectedLogoUrl = $(this).val();

            // Update the image source
            $('#selectedLogo').attr('src', selectedLogoUrl);

            // Check if the selected logo is the white logo
            if (selectedLogoUrl === "{{ asset('assets/images/wslah_white.png') }}") {
                // Set the background to black
                $('#selectedLogo').css('background', '#000');
            } else {
                // Remove the background
                $('#selectedLogo').css('background', 'none');
            }
        });
    });
</script>

<script>
    $(document).ready(function () {
        // Get the initially selected value
        var initialSelectedSocialMediaIcon = $('#socialMediaSelect').val();

        // Update the image source
        $('#selectedSocialMediaIcon').attr('src', initialSelectedSocialMediaIcon);

        // Check if the initially selected icon is the white icon
        if (initialSelectedSocialMediaIcon === "{{ asset('assets/images/Instagram_white.png') }}" || initialSelectedSocialMediaIcon === "{{ asset('assets/images/x_white.png') }}") {
            // Set the background to black
            $('#selectedSocialMediaIcon').css('background', '#000');

        }else if(initialSelectedSocialMediaIcon === "{{asset('assets/images/insta.gif')}}"){
            $('#insta-profile').show();
            $('#insta-preview-image').show();


            var previewContainer = $('#insta-preview-image');
            var img = '{{$row->profile_picture}}';
            var imageElement = $('<img width="110px">').attr('src', "{{ asset('storage/' . $row->profile_picture) }}").addClass('preview-image');
            previewContainer.append(imageElement);
        }

        // Add an event listener to the dropdown using jQuery
        $('#socialMediaSelect').change(function () {
            // Get the selected value
            var selectedSocialMediaIcon = $(this).val();


            // Update the image source
            $('#selectedSocialMediaIcon').attr('src', selectedSocialMediaIcon);

            // Check if the selected icon is the white icon
            if (selectedSocialMediaIcon === "{{ asset('assets/images/Instagram_white.png') }}" || selectedSocialMediaIcon === "{{ asset('assets/images/x_white.png') }}") {
                // Set the background to black
                $('#selectedSocialMediaIcon').css('background', '#000');
            } else {
                // Remove the background
                $('#selectedSocialMediaIcon').css('background', 'none');
            }

            if (selectedSocialMediaIcon === "{{asset('assets/images/insta.gif')}}") {
                $('#insta-profile').show();
            } else {
                $('#insta-profile').hide();
            }
        });

        $('#is_coming_soon').change(function () {
            $('#comingSoonTitleField').toggle(this.checked);
            $('#comingSoonDateTimeFields').toggle(this.checked);
        });

    });

</script>

<script>
    // Function to handle file input change using jQuery
    $(document).on('change', '#profile_picture', function (e) {
      var previewContainer = $('#insta-preview-image');
      var files = e.target.files;

      // Clear previous preview
      previewContainer.empty();

      // Check if any file is selected
      if (files.length > 0) {
        var reader = new FileReader();

        // Read the selected file as Data URL
        reader.readAsDataURL(files[0]);

        // Set up the reader onload event
        reader.onload = function (event) {
          // Create an image element with the preview image
          var imageElement = $('<img width="110px">').attr('src', event.target.result).addClass('preview-image');

          // Append the image to the preview container
          previewContainer.append(imageElement);

          // Show the preview container
          previewContainer.show();
        };
      } else {
        // Hide the preview container if no file is selected
        previewContainer.hide();
      }
    });
  </script>


     @endpush
     @endpush
