<!DOCTYPE html>
<?php
    if (Session()->has('admin_locale')) {
        $langCode = Session()->get('admin_locale');
    }
    else {
        $langCode = config('app.fallback_locale');
    }

    if (Request::segment(3) == 'all-setting') {
        Session::forget('imagePath');
    }
    
    $direction = \Helpers::getLanguageDirection($langCode);
?>
<html lang="{{$langCode}}" class="@if(isset($_COOKIE['theme'])) @if($_COOKIE['theme']=='dark') dark-style @else light-style @endif @else light-style @endif layout-navbar-fixed layout-menu-fixed" dir="{{$direction}}" data-theme="theme-default" data-assets-path="{{asset('/admin-assets/')}}" data-template="vertical-menu-template">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{setting('site_admin_name')}}</title>
    <meta name="description" content="" />
    @if(setting('site_favicon')!='')
    <link rel="icon" type="image/x-icon" href="{{url('uploads/setting/'.setting('site_favicon'))}}" />
    @else
    <link rel="icon" type="image/x-icon" href="{{url('uploads/no-favicon.png')}}" />
    @endif
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    
    <script>
      var base_url = "{{url('')}}";
    </script>
    <script>
        var editorInstance; // Global variable to store the editor instance
    </script>
    <!-- All icons css -->
    <link rel="stylesheet" href="{{ asset('admin-assets/font/font.css')}}" />
    <link rel="stylesheet" href="{{ asset('admin-assets/vendor/fonts/icons.css')}}" />
    <!-- All icons css -->
    <!-- All theme css -->
    
    <!-- All icons css -->
    <!-- All core css -->
    @if(isset($_COOKIE['theme']))
      @if($_COOKIE['theme']=='dark')
        <link rel="stylesheet" href="{{ asset('admin-assets/vendor/css/rtl/theme-dark.css')}}" id="theme-style" />
      @else
        <link rel="stylesheet" href="{{ asset('admin-assets/vendor/css/rtl/theme.css')}}" id="theme-style" />
      @endif
    @else
    <link rel="stylesheet" href="{{ asset('admin-assets/vendor/css/rtl/theme.css')}}" id="theme-style" />
    @endif
    <!-- All icons css -->
    <!-- All plugin css -->
    
    <link rel="stylesheet" href="{{ asset('admin-assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}" />
    <link rel="stylesheet" href="{{ asset('admin-assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}" />
    <link rel="stylesheet" href="{{ asset('admin-assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css')}}" />
    <link rel="stylesheet" href="{{ asset('admin-assets/vendor/libs/toastr/toastr.css')}}" />
    <link rel="stylesheet" href="{{ asset('admin-assets/css/custom.css')}}"/>
    <link rel="stylesheet" href="{{ asset('admin-assets/vendor/libs/sweetalert2/sweetalert2.css')}}" />
    <link rel="stylesheet" href="{{ asset('admin-assets/vendor/libs/dropzone/dropzone.css')}}" />
    <link rel="stylesheet" href="{{ asset('admin-assets/vendor/libs/spinkit/spinkit.css')}}" />
    <link rel="stylesheet" href="{{ asset('admin-assets/vendor/libs/select2/select2.css')}}" />

    <style type="text/css">
        img.image-preview-cls {
            width: 150px;
            height: 150px;
        }

        label.btn.btn-primary.me-75.mb-0 {
            width: 150px;
            margin-top: 5px;
        }

        iframe.image-preview-cls {
            width: 150px;
            height: 150px;
        }
        img.image-preview-cls[src*="no-image.png"] {
            object-fit: fill;
        }

        img.image-preview-cls:not([src*="no-image.png"]) {
            object-fit: contain;
        }

        img.image-preview-cls[src*="image_preview.jpg"] {
            border: 1px dotted;
        }

        p.img-label {
            margin-top: 7px;
        }

        p.img-resolution {
            margin-top: -15px;
        }
    </style>

    <!-- All plugin css -->
    <script src="{{ asset('admin-assets/vendor/js/helpers.js')}}"></script>
    <script src="{{ asset('admin-assets/js/config.js')}}"></script>
    <script>
        window.translations = {
            locale: '{{ app()->getLocale() }}',
            messages: @json(__('lang'))
        };
    </script>
    <!-- Full-Screen Loader -->
    <div id="fullScreenLoader" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.7); z-index: 9999; justify-content: center; align-items: center;">
        <div class="spinner-border text-light" role="status" style="width: 5rem; height: 5rem;">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
  </head>
  <body> 
    @if(Request::segment(1)=='admin') 
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container"> 
        @include('admin/layout/component/menu') 
        <div class="layout-page"> 
          @include('admin/layout/component/header') 
          <div class="content-wrapper"> 
            @yield('content') @include('admin/layout/component/footer') 
            <div class="content-backdrop fade"></div>
          </div>
        </div>
      </div>
      <div class="layout-overlay layout-menu-toggle"></div>
      <div class="drag-target"></div>
    </div> 
    @else 
      @yield('content') 
    @endif
    <script src="{{ asset('admin-assets/vendor/libs/jquery/jquery.js')}}"></script>
    @if(Request::segment(2)!='dashboard' || Request::segment(2)!='')
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    @endif
    <script src="{{ asset('admin-assets/vendor/js/bootstrap.js')}}"></script>
    <script></script>
    <script src="{{ asset('admin-assets/vendor/js/menu.js')}}"></script>
    <script src="{{ asset('admin-assets/vendor/libs/dropzone/dropzone.js')}}"></script>
    <script src="{{ asset('admin-assets/vendor/libs/apex-charts/apexcharts.js')}}"></script>
    <script src="{{ asset('admin-assets/vendor/libs/swiper/swiper.js')}}"></script>
    <script src="{{ asset('admin-assets/vendor/libs/toastr/toastr.js')}}"></script>
    <script src="{{ asset('admin-assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
    <script src="{{ asset('admin-assets/vendor/libs/flatpickr/flatpickr.js')}}"></script>
    <script src="{{ asset('admin-assets/vendor/libs/jquery-repeater/jquery-repeater.js')}}"></script>
    <script src="{{ asset('admin-assets/vendor/libs/select2/select2.js')}}"></script>
    <script src="{{ asset('admin-assets/vendor/libs/tagify/tagify.js')}}"></script>   
    <script src="{{ asset('admin-assets/js/main.js')}}"></script>
    <script src="{{ asset('admin-assets/vendor/libs/chartjs/chartjs.js')}}"></script>
    <script src="{{ asset('admin-assets/js/forms-file-upload.js')}}"></script>
    <script src="{{ asset('admin-assets/js/dashboards-analytics.js')}}"></script>
    <script src="{{ asset('admin-assets/js/dashboards-crm.js')}}"></script>
    <script src="{{ asset('admin-assets/js/theme.js')}}"></script>
    <script src="{{ asset('admin-assets/js/custom.js')}}"></script>
    <script src="{{ asset('admin-assets/js/ui-toasts.js')}}"></script>
    <script src="{{ asset('admin-assets/js/tables-datatables-basic.js')}}"></script>
    <script src="{{ asset('admin-assets/js/validation.js')}}"></script>
    <script src="{{ asset('admin-assets/js/forms-pickers.js')}}"></script>
    <script src="{{ asset('admin-assets/js/forms-extras.js')}}"></script>
    <script src="{{ asset('admin-assets/js/forms-selects.js')}}"></script>
    <script src="{{ asset('admin-assets/js/forms-tagify.js')}}"></script>
    <script src="{{ asset('admin-assets/js/charts-chartjs.js')}}"></script>
    <?php if(Request::segment(2)!='add-blog' || Request::segment(1)!='admin-login'){ 
        $session_id = md5(uniqid(rand(), true));
        Session::put('session_id', $session_id);  
    } ?>

    @if(Session::has('error'))
      <script>
        toastr['error']('', "{{ session('error') }}");
      </script>
    @endif
    @if(Session::has('info'))
      <script>
        toastr['info']('', "{{ session('info') }}");
      </script>
    @endif
    @if(Session::has('warning'))
      <script>
        toastr['warning']('', "{{ session('warning') }}");
      </script>
    @endif
    @if(Session::has('success'))
      <script>
        toastr['success']('', "{{ session('success') }}");
      </script>
    @endif
    <script>
    $(".flatpickr-datetime").flatpickr({
      enableTime: true,
      dateFormat: 'Y-m-d h:i K',
      timezone: "<?php echo setting('timezone'); ?>",
    });
    $(".flatpickr-date").flatpickr({
      enableTime: false,
      dateFormat: 'Y-m-d',
      timezone: "<?php echo setting('timezone'); ?>",
    });
    $(".flatpickr-range").flatpickr({
      mode: 'range',
      enableTime: true,
    });
    $(document).ready(function() {
      
      $('.category_id').select2({
        placeholder: '{{ __('lang.admin_select_category') }}'
      });
      $('.sub_category_id').select2({
        placeholder: '{{ __('lang.admin_select_subcategory') }}'
      });
      $('.email').select2({
        placeholder: '{{ __('lang.admin_select_email') }}'
      });
      $("#ad_table").sortable({
            items: "tr",
            cursor: 'move',
            opacity: 0.6,
            update: function () {
                sendOrderofAdsToServer();
            }
        });

      function sendOrderofAdsToServer(ad_id) {
            var order = [];
            var token = $('meta[name="csrf-token"]').attr('content');
            $('tr.row1').each(function (index, element) {
                order.push({
                    id: $(this).attr('data-id'),
                    position: index + 1
                });
            });
            $.ajax({
                type: "POST",
                dataType: "json",
                url: base_url + "/admin/ads-sortable",
                data: {
                    order: order,
                    _token: token
                },
                success: function (response) {
                    if (response.status == "success") {
                        console.log(response);
                    } else {
                        console.log(response);
                    }
                }
            });
        }
    });
    </script>
    <script>
        $("#app_home_page_table").sortable({
            items: "tr",
            cursor: 'move',
            opacity: 0.6,
            update: function () {
                sendOrderofAppHomePageToServer();
            }
        });
            
        function sendOrderofAppHomePageToServer() {
            var order = [];
            var token = $('meta[name="csrf-token"]').attr('content');
            $('tr.apphomepagerow1').each(function (index, element) {
                order.push({
                    id: $(this).attr('data-id'),
                    position: index + 1
                });
            });
            $.ajax({
                type: "POST",
                dataType: "json",
                url: base_url + "/admin/app-home-page-sortable",
                data: {
                    order: order,
                    _token: token
                },
                success: function (response) {
                    if (response.status == "success") {
                        console.log(response);
                    } else {
                        console.log(response);
                    }
                }
            });
        }
    </script>
    @if(Request::segment(2)=='dashboard' || (Request::segment(1)=='admin' && Request::segment(2)==''))
    <?php $graphData = \Helpers::getUserOnTheBasisOfDate();
    $pieChartData = \Helpers::getSignupOnTheBasisOftype(); 
    ?>
    <script>
      $(function () {
        const purpleColor = '#836AF9',
        yellowColor = '#ffe800',
        cyanColor = '#28dac6',
        orangeColor = '#FF8132',
        orangeLightColor = '#FDAC34',
        oceanBlueColor = '#299AFF',
        greyColor = '#4F5D70',
        greyLightColor = '#EDF1F4',
        blueColor = '#2B9AFF',
        blueLightColor = '#84D0FF';

        let cardColor, headingColor, labelColor, borderColor, legendColor;

        if (isDarkStyle) {
          cardColor = config.colors_dark.cardColor;
          headingColor = config.colors_dark.headingColor;
          labelColor = config.colors_dark.textMuted;
          legendColor = config.colors_dark.bodyColor;
          borderColor = config.colors_dark.borderColor;
        } else {
          cardColor = config.colors.cardColor;
          headingColor = config.colors.headingColor;
          labelColor = config.colors.textMuted;
          legendColor = config.colors.bodyColor;
          borderColor = config.colors.borderColor;
        }
        $(".flatpickr-range").flatpickr({
            mode: 'range',
            enableTime: true,
            defaultDate: [<?php echo json_encode($graphData['chart_start_date']); ?>, <?php echo json_encode($graphData['chart_end_date']); ?>],
        });
        const barChart = document.getElementById('barChart1');
        if (barChart) {
          const barChartVar = new Chart(barChart, {
            type: 'bar',
            data: {
              labels: <?php echo json_encode($graphData['dates']); ?>,
              datasets: [
                {
                  data: <?php echo json_encode($graphData['users']); ?>,
                  backgroundColor: cyanColor,
                  borderColor: 'transparent',
                  maxBarThickness: 15,
                  borderRadius: {
                    topRight: 15,
                    topLeft: 15
                  }
                }
              ]
            },
            options: {
              responsive: true,
              maintainAspectRatio: false,
              animation: {
                duration: 500
              },
              plugins: {
                tooltip: {
                  rtl: isRtl,
                  backgroundColor: cardColor,
                  titleColor: headingColor,
                  bodyColor: legendColor,
                  borderWidth: 1,
                  borderColor: borderColor
                },
                legend: {
                  display: false
                }
              },
              scales: {
                x: {
                  grid: {
                    color: borderColor,
                    drawBorder: false,
                    borderColor: borderColor
                  },
                  ticks: {
                    color: labelColor
                  }
                },
                y: {
                  min: 0,
                  max: <?php if(json_encode($graphData['highest_count'])>0){ echo json_encode($graphData['highest_count']); }else{
                    echo "5"; } ?>,
                  grid: {
                    color: borderColor,
                    drawBorder: false,
                    borderColor: borderColor
                  },
                  ticks: {
                    stepSize: 1,
                    color: labelColor
                  }
                }
              }
            }
          });
        }
        const doughnutChart = document.getElementById('doughnutChart');
        console.log(doughnutChart);
        if (doughnutChart) {
          const doughnutChartVar = new Chart(doughnutChart, {
            type: 'doughnut',
            data: {
              labels: <?php echo json_encode($pieChartData['types']); ?>,
              datasets: [
                {
                  data: <?php echo json_encode($pieChartData['users']); ?>,
                  backgroundColor: ['#3b5998', '#EA4335', '#28dac6','#dcd9e7'],
                  borderWidth: 0,
                  pointStyle: 'rectRounded'
                }
              ]
            },
            options: {
              responsive: true,
              animation: {
                duration: 500
              },
              cutout: '68%',
              plugins: {
                legend: {
                  display: false
                },
                tooltip: {
                  callbacks: {
                    label: function (context) {
                      const label = context.labels || '',
                        value = context.parsed;
                      const output = ' ' + label + ' : ' + value + ' %';
                      return output;
                    }
                  },
                  // Updated default tooltip UI
                  rtl: isRtl,
                  backgroundColor: '#2f3349',
                  titleColor: '#cfd3ec',
                  bodyColor: '#b6bee3',
                  borderWidth: 1,
                  borderColor: '#434968'
                }
              }
            }
          });
        }
      });
    </script>
    @endif
    <script>
        $(function () {
            previewTemplate = `<div class="dz-preview dz-file-preview">
            <div class="dz-details">
              <div class="dz-thumbnail">
                <img data-dz-thumbnail>
                <span class="dz-nopreview">No preview</span>
                <div class="dz-success-mark"></diva>
                <div class="dz-error-mark"></div>
                <div class="dz-error-message"><span data-dz-errormessage></span></div>
                <div class="progress">
                  <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuemin="0" aria-valuemax="100" data-dz-uploadprogress></div>
                </div>
              </div>
              <div class="dz-filename" data-dz-name style="margin-top: 11px;margin-left: -11px;"></div>
              <div class="dz-size" data-dz-size style="margin-top: 10px;"></div>
            </div>
            </div>`;
            new Dropzone('#dropzone-multi', {
              previewTemplate: previewTemplate,
              parallelUploads: 1,
              maxFilesize: 5,
              addRemoveLinks: true,
              acceptedFiles: 'image/*',
              init: function() {
                  var dropzoneInstance = this;
                  this.on("success", function(file, response) {
                      console.log(file);
                      console.log(response);

                      var blog_id = 0;
                      <?php if(Request::segment(2)=='update-blog'){ ?>
                        blog_id = "<?php echo Request::segment(4); ?>"
                      <?php } ?>
                      var data = new FormData();
                      data.append('file', file);
                      data.append('blog_id', blog_id);
                      $.ajaxSetup({
                          headers: {
                              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                          }
                      });
                      $(".showLoader").removeClass('hide');
                      setTimeout(function() {
                          $.ajax({
                              url: base_url + '/admin/store-image',
                              type: 'POST',
                              data: data,
                              dataType: 'json',
                              processData: false,
                              contentType: false,
                              success: function(res) {
                                  console.log(res);                        
                                  $("#image_names").val(res.data.blog_image);
                                  $("#previewsContainer").html(res.data.html);
                                  $(".showLoader").addClass('hide');
                                  // Handle the AJAX response here, if needed
                              },
                              error: function(xhr, status, error) {
                                  console.log(error);
                                  $(".showLoader").addClass('hide');
                                  // Handle the AJAX error here, if needed
                              }
                          });
                      }, 2000);
                  });
                  
                  this.on("error", function(file, errorMessage) {
                      console.log(errorMessage);
                      // Handle the error event here, if needed
                  });

                  this.on("removedfile", function(file) {
                      var blog_id = 0;
                      <?php if(Request::segment(2)=='update-blog'){ ?>
                        blog_id = "<?php echo Request::segment(4); ?>"
                      <?php } ?>
                      // Call your API here to handle the removal of the file
                      $(".showLoader").removeClass('hide');
                      $.ajax({
                          url: base_url + '/admin/remove-image-by-name',
                          type: 'POST',
                          data: { filename: file.name,blog_id:blog_id },
                          dataType: 'json',
                          success: function(res) {
                              console.log(res);
                              $("#previewsContainer").html(res.data.html);
                              // Handle the AJAX response here, if needed
                              $(".showLoader").addClass('hide');
                          },
                          error: function(xhr, status, error) {
                              console.log(error);
                              // Handle the AJAX error here, if needed
                              $(".showLoader").addClass('hide');
                          }
                      });
                  });
              }
          });

          $(".image_position").sortable({
              // items: "div",
              cursor: 'move',
              // opacity: 0.6,
              update: function () {
                  sendOrderofImagesToServer();
              }
          });

          function sendOrderofImagesToServer() {
            var order = [];
            var token = $('meta[name="csrf-token"]').attr('content');
            $('div.row1').each(function (index, element) {
                order.push({
                    id: $(this).attr('data-id'),
                    position: index + 1
                });
            });
            var blog_id = 0;
            <?php if(Request::segment(2)=='update-blog'){ ?>
                blog_id = "<?php echo Request::segment(4); ?>"
            <?php } ?>
            $.ajax({
                type: "POST",
                dataType: "json",
                url: base_url + "/admin/blog-image-sortable",
                data: {
                    blog_id:blog_id,
                    order: order,
                    _token: token
                },
                success: function (response) {
                    if (response.status == "success") {
                        console.log(response);
                    } else {
                        console.log(response);
                    }
                }
            });
          }       
      });
    </script>
    <script>
        $(document).ready(function() {
            // Check/uncheck all checkboxes when parent checkbox is clicked
            $('#selectAll').click(function() {
                $('.selectCheckbox').prop('checked', $(this).prop('checked'));
            });

            // Delete selected checkboxes
            $('#deleteSelected').click(function() {
                var ids = [];
                $('.selectCheckbox:checked').each(function() {
                    ids.push($(this).val());
                });

                if (ids.length > 0) {
                    // Use SweetAlert for confirmation
                   Swal.fire({
                        title: adminTranslation.admin_are_you_sure,
                        text: adminTranslation.admin_delete_warning,
                        icon: adminTranslation.admin_warning,
                        showCancelButton: true,
                        confirmButtonText: adminTranslation.admin_delete_warning_yes_button,
                        cancelButtonText: adminTranslation.admin_delete_warning_no_button,
                        customClass: {
                          confirmButton: 'btn btn-primary me-3',
                          cancelButton: 'btn btn-label-secondary'
                        },
                        buttonsStyling: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $('#selectedIds').val(ids);
                            // Submit the form to delete selected items
                            $('#deleteForm').submit();
                        }
                    });
                } else {
                    toastr['warning']('', "Please select at least one item to delete.");
                }
            });
        });
    </script>
    <script type="text/javascript">
      $(document).ready(function() {
          $('.form-control').filter('select').addClass('form-select');
      })
    </script>
    <script>
        $(document).on('click','.send_notification_to_users',function(){
            var id = $(this).attr('data-id');
            $('.hidden_id').val(id);
            $('#sendNotificationModal').modal('show');
        });

        $(document).on('click','.close_send_notification_modal',function(){
            $('#sendNotificationModal').modal('hide');
        });

        $(document).on('click', '#sendNotificationBtn', function (e) {
            e.preventDefault();

            var form = $('#sendNotificationForm');
            var formData = form.serialize();
            var submitButton = $(this);
            
            // Show loader and disable button
            submitButton.prop('disabled', true);
            submitButton.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Sending...');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: formData,
                success: function (response) {
                  // Success Message
                  myToastr(response.message,response.type);
                  $('#sendNotificationModal').modal('hide');
                },
                error: function (xhr) {
                  var response = xhr.responseJSON;
                  // Error Message
                  if(response.statusCode == 422){
                    myToastr(response.message,response.type);
                  }
                },
                complete: function () {
                    // Reset Button
                    submitButton.prop('disabled', false);
                    submitButton.html('Send Notification');
                }
            });
        });
      </script>
      <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll(".save-post-form").forEach(function (form) {
                form.addEventListener("submit", function () {
                    document.getElementById("fullScreenLoader").style.display = "flex"; 
                });
            });
        });
      </script>
  </body>
</html>