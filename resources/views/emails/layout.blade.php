<!DOCTYPE html>
<html lang="en">
<head>
  <title>Mosufy | Lumen - API</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
  <style type="text/css">
    /* CLIENT-SPECIFIC STYLES */
    #outlook a {
      padding: 0;
    }

    /* Force Outlook to provide a "view in browser" message */
    .ReadMsgBody {
      width: 100%;
    }

    .ExternalClass {
      width: 100%;
    }

    /* Force Hotmail to display emails at full width */
    .ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {
      line-height: 100%;
    }

    /* Force Hotmail to display normal line spacing */
    body, table, td, a {
      -webkit-text-size-adjust: 100%;
      -ms-text-size-adjust: 100%;
    }

    /* Prevent WebKit and Windows mobile changing default text sizes */
    table, td {
      mso-table-lspace: 0pt;
      mso-table-rspace: 0pt;
    }

    /* Remove spacing between tables in Outlook 2007 and up */
    img {
      -ms-interpolation-mode: bicubic;
    }

    /* Allow smoother rendering of resized image in Internet Explorer */

    /* RESET STYLES */
    body {
      margin: 0;
      padding: 0;
    }

    img {
      border: 0;
      height: auto;
      line-height: 100%;
      outline: none;
      text-decoration: none;
    }

    table {
      border-collapse: collapse !important;
    }

    body {
      height: 100% !important;
      margin: 0;
      padding: 0;
      width: 100% !important;
    }

    /* iOS BLUE LINKS */
    .appleBody a {
      color: #68440a;
      text-decoration: none;
    }

    .appleFooter a {
      color: #999999;
      text-decoration: none;
    }

    /* MOBILE STYLES */
    @media screen and (max-width: 525px) {

      /* ALLOWS FOR FLUID TABLES */
      table[class="wrapper"] {
        width: 100% !important;
      }

      /* ADJUSTS LAYOUT OF LOGO IMAGE */
      td[class="logo"] {
        text-align: left;
        padding: 20px 0 20px 0 !important;
      }

      td[class="logo"] img {
        margin: 0 auto !important;
      }

      /* USE THESE CLASSES TO HIDE CONTENT ON MOBILE */
      td[class="mobile-hide"] {
        display: none;
      }

      img[class="mobile-hide"] {
        display: none !important;
      }

      img[class="img-max"] {
        max-width: 100% !important;
        height: auto !important;
      }

      /* FULL-WIDTH TABLES */
      table[class="responsive-table"] {
        width: 100% !important;
      }

      /* UTILITY CLASSES FOR ADJUSTING PADDING ON MOBILE */
      td[class="padding"] {
        padding: 10px 5% 15px 5% !important;
      }

      td[class="padding-copy"] {
        padding: 10px 5% 10px 5% !important;
        text-align: center;
      }

      td[class="padding-meta"] {
        padding: 30px 5% 0px 5% !important;
        text-align: center;
      }

      td[class="no-pad"] {
        padding: 0 0 20px 0 !important;
      }

      td[class="no-padding"] {
        padding: 0 !important;
      }

      td[class="section-padding"] {
        padding: 10px 15px 10px 15px !important;
      }

      td[class="section-padding-bottom-image"] {
        padding: 50px 15px 0 15px !important;
      }

      /* ADJUST BUTTONS ON MOBILE */
      td[class="mobile-wrapper"] {
        padding: 10px 5% 15px 5% !important;
      }

      table[class="mobile-button-container"] {
        margin: 0 auto;
        width: 100% !important;
      }

      a[class="mobile-button"] {
        width: 80% !important;
        padding: 15px !important;
        border: 0 !important;
        font-size: 16px !important;
      }

    }
  </style>
</head>
<body style="margin: 0; padding: 0;">

<!-- HEADER -->
<table border="0" cellpadding="0" cellspacing="0" width="100%">
  <tr>
    <td bgcolor="#C80003">
      <!-- HIDDEN PREHEADER TEXT -->
      <div style="display: none; font-size: 1px; color: #fefefe; line-height: 1px; font-family: Helvetica, Arial, sans-serif; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden;">
        @yield('prelude')
      </div>
      <div align="center" style="padding: 0px 15px 0px 15px;">
        <table border="0" cellpadding="0" cellspacing="0" width="500" class="wrapper">
          <!-- LOGO/PREHEADER TEXT -->
          <tr>
            <td style="padding: 20px 0px 30px 0px;" class="logo">
              <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                  <td bgcolor="#C80003" width="222" align="left">
                    <a href="https://github.com/mosufy/lumen-api" target="_blank"><img alt="Mosufy | Lumen - API" src="http://placehold.it/220x50" width="220" height="50" style="display: block; font-family: Helvetica, Arial, sans-serif; color: #666666; font-size: 16px;" border="0"></a>
                  </td>
                  <td bgcolor="#C80003" width="200" align="right" class="mobile-hide">
                    <table border="0" cellpadding="0" cellspacing="0">
                      <tr>
                        <td align="right" style="padding: 0 0 5px 0; font-size: 14px; font-family: Arial, sans-serif; color: #666666; text-decoration: none;">
                          <span style="color: #666666; text-decoration: none;">&nbsp;</span>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </div>
    </td>
  </tr>
</table>

<!-- ONE COLUMN SECTION -->
<table border="0" cellpadding="0" cellspacing="0" width="100%">
  <tr>
    <td bgcolor="#FFFFFF" align="center" style="padding: 10px 15px 70px 15px;" class="section-padding">
      <table border="0" cellpadding="0" cellspacing="0" width="500" class="responsive-table">
        <tr>
          <td>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td>
                  <!-- COPY -->
                @yield('content')
                <!-- /END COPY -->
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>

<!-- FOOTER -->
<table border="0" cellpadding="0" cellspacing="0" width="100%">
  <tr>
    <td bgcolor="#FFF4F4" align="center" style="padding: 20px 0px;">
      <!-- UNSUBSCRIBE COPY -->
      <table width="500" border="0" cellspacing="0" cellpadding="0" align="center" class="responsive-table">
        <tr>
          <td align="center" valign="middle" style="font-size: 12px; line-height: 18px; font-family: Helvetica, Arial, sans-serif; color:#666666;">
            <span class="appleFooter" style="color:#666666;">
              You are receiving this email because you have registered for an account on
              <a href="https://github.com/mosufy/lumen-api" target="_blank">https://github.com/mosufy/lumen-api</a>.
              If you have not done so, please accept our apologies and kindly let us know by sending an email to
              <a href="mailto:mail@email.com">mail@email.com</a>.
              You may also ignore this email.
            </span>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>

</body>
</html>