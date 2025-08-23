@php
$localVersion = \Helpers::getVersion(base_path('public/version.json'));
@endphp
<footer class="content-footer footer bg-footer-theme">
  <div class="container-xxl">
    <div class="footer-container d-flex align-items-center justify-content-between py-2 flex-md-row flex-column">
      <div><a href="{{url('/')}}" target="_blank" class="fw-semibold"> © {{date('Y')}} {{__('lang.admin_footer_made_with')}} {{setting('site_name')}}</a>
      </div>
      <div>
         {{__('lang.admin_version')}} : {{$localVersion}}
      </div>
    </div>
  </div>
</footer>

<!-- =============Model====================== -->
<div class="modal fade" id="sendNotificationModal" tabindex="-1" role="dialog" aria-labelledby="notificationModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="{{route('send-notification-to-users')}}" method="post" id="sendNotificationForm">
          @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="notificationModalLabel">Send Notification</h5>
          <button type="button" class="close_send_notification_modal" style="border: 0;font-size: 20px;color: red;">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body row">
          <div class="form-group col-sm-6 col-md-6">
            <label>
              <input type="radio" name="recipient" value="all_users" checked>
               {{__('lang.admin_all_users')}}
            </label>
          </div>
          <div class="form-group col-sm-6 col-md-6">
            <label>
              <input type="radio" name="recipient" value="preferred_users">
              {{__('lang.admin_feed_users')}}
            </label>
          </div>
          <input type="hidden" name="id" class="hidden_id">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary close_send_notification_modal">Close</button>
          <button type="button" id="sendNotificationBtn" class="btn btn-primary">Send Notification</button>
        </div>
      </form>
    </div>
  </div>
</div>