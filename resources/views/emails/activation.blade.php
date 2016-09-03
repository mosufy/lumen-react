@extends('emails.layout')

@section('content')
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td style="font-size: 25px; font-family: Helvetica, Arial, sans-serif; color: #333333; padding-top: 30px;" class="padding-copy">
        Hello {{ $user['name'] }}
      </td>
    </tr>
    <tr>
      <td style="padding: 20px 0 0 0; font-size: 16px; line-height: 25px; font-family: Helvetica, Arial, sans-serif; color: #666666;" class="padding-copy">
        <p class="lead">Thank you for signing up!</p>

        <p class="lead">Before you continue, we need you to confirm that you have signed up with us. Simply click
          the button below to confirm your registration!</p>
      </td>
    </tr>
    <tr>
      <td align="center">
        <!-- BULLETPROOF BUTTON -->
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="mobile-button-container">
          <tr>
            <td align="center" style="padding: 10px 0 0 0;" class="padding-copy">
              <table border="0" cellspacing="0" cellpadding="0" class="responsive-table">
                <tr>
                  <td align="center">
                    <a href="{{ $data['activation_url'] }}" target="_blank" style="font-size: 18px; font-family: Helvetica, Arial, sans-serif; font-weight: normal; color: #ffffff; text-decoration: none; background-color: #C80003; border-top: 15px solid #C80003; border-bottom: 15px solid #C80003; border-left: 25px solid #C80003; border-right: 25px solid #C80003; border-radius: 3px; -webkit-border-radius: 3px; -moz-border-radius: 3px; display: inline-block;" class="mobile-button">
                      Activate My Account
                    </a>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
@endsection