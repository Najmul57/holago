<!DOCTYPE html>
<html>
<head>
	<title>{{ $title }}</title>
	<style>
		.info{
			margin-top: 40px;
		    margin-left: 40px;
		    margin-bottom: 25px;
		}
		p{
			margin: 0;
			margin-bottom: 10px;
		}
		h4{
			margin: 0;
			margin-bottom: 10px;
		}
	</style>
</head>
<body>
	<div class="info">
		<h4>{{ __($email_details->subject) }}</h4>
		<p><strong>@lang('To'): </strong> {{ $email_details->email_to }}</p>
		<p><strong>@lang('From'): </strong> {{ __($setting->site_name) }} {{'<'.$email_details->email_from.'>'}}</p>
		<p><strong>@lang('Via'): </strong> <span>@</span>{{ __($email_details->mail_sender) }} {{ showDateTime($email_details->created_at) }}</p>
	</div>
	@php echo $email_details->message @endphp
</body>
</html>