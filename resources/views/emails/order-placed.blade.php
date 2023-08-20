<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<body style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; background-color: #f5f8fa; color: #74787e; height: 100%; hyphens: auto; line-height: 1.4; margin: 0; -moz-hyphens: auto; -ms-word-break: break-all; width: 100% !important; -webkit-hyphens: auto; -webkit-text-size-adjust: none; word-break: break-word;">
	<style>
		@media  only screen and (max-width: 600px) {
			.inner-body {
				width: 100% !important;
			}

			.footer {
				width: 100% !important;
			}
		}

		@media  only screen and (max-width: 500px) {
			.button {
				width: 100% !important;
			}
		}
	</style>
	<table class="wrapper" width="100%" cellpadding="0" cellspacing="0" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; background-color: #f5f8fa; margin: 0; padding: 0; width: 100%; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%;"><tr>
		<td align="center" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">
			<table class="content" width="100%" cellpadding="0" cellspacing="0" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; margin: 0; padding: 0; width: 100%; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%;">
				<tr>
					<td class="header" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; padding: 25px 0; text-align: center;">
						<a href="{{ config('app.url') }}" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #bbbfc3; font-size: 19px; font-weight: bold; text-decoration: none; text-shadow: 0 1px 0 #ffffff;">
							{{-- {{ config('app.name') }} --}}
							{{-- <br> --}}
							<img src="{{ asset('images/logo.png') }}" alt="{{ config('app.name') }}">
						</a>
					</td>
				</tr>

				<!-- Email Body -->
				<tr>
					<td class="body" width="100%" cellpadding="0" cellspacing="0" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; background-color: #ffffff; border-bottom: 1px solid #edeff2; border-top: 1px solid #edeff2; margin: 0; padding: 0; width: 100%; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%;">
						<table class="inner-body" align="center" width="570" cellpadding="0" cellspacing="0" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; background-color: #ffffff; margin: 0 auto; padding: 0; width: 570px; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 570px;">
							<!-- Body content --><tr>
								<td class="content-cell" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; padding: 35px;">
									<p style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787e; font-size: 16px; line-height: 1.5em; margin-top: 0; text-align: left;">
										Dear {{ $order->addresses->billing_first_name }},  Your order has been received and now being processed.
									</p>

									<p style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787e; font-size: 16px; line-height: 1.5em; margin-top: 0; text-align: left;">
										If you have questions about your order, you can email us at <a href="mailTo:{{ getenv('MAIL_FROM_ADDRESS') }}">{{ getenv('MAIL_FROM_ADDRESS') }}</a> or call us on <a href="tel:{{ getenv('CONTACT_PHONE') }}">{{ getenv('CONTACT_PHONE') }}</a>
									</p>

									<h2 style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #2F3133; font-size: 18px; font-weight: bolder; margin-top: 15px margin-bottom: 15px; text-align: center;">
										Your Order #{{ $order->order_number }}
									</h2>

									<p style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787e; font-size: 16px; line-height: 1.5em; margin-top: 15px; text-align: center;">
										ORDER DETAILS 
									</p>

									<div class="table" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">
										<table style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; margin: 15px 30px 30px 30px auto; width: 100%; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%;">
											<tbody style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">
												@foreach($order->products as $product)
												<tr>
													<td style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787e; font-size: 15px; line-height: 18px; padding: 10px 0;">
														{{ $product->name }} * {{ $product->pivot->quantity }}
													</td>
													<td style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787e; font-size: 15px; line-height: 18px; padding: 10px 0; text-align: right;">{{ config('adinkra.currency_code') }}{{ number_format(($product->pivot->price *  $product->pivot->quantity), 2) }}</td>
												</tr>
												@endforeach

												<tr style="width: 50%; float: right;">
													<tr>
														<td style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787e; font-size: 15px; line-height: 18px; padding: 10px 0; ">
														Subtotal</td>
														<td style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787e; font-size: 15px; line-height: 18px; padding: 10px 0; text-align: right;">{{ number_format($order->subtotal, 2) }}</td>
													</tr>
													<tr>
														<td style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787e; font-size: 15px; line-height: 18px; padding: 10px 0; ">
														Shipping</td>
														<td style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787e; font-size: 15px; line-height: 18px; padding: 10px 0; text-align: right;">
															@if($order->shipping_amount  > 0)
															{{ config('adinkra.currency_code') }}{{ number_format($order->shipping_amount, 2) }}
															@else
															Free shipping
															@endif
														</td>
													</tr>
													<tr>
														<td style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787e; font-size: 15px; line-height: 18px; padding: 10px 0; ">
														Vat</td>
														<td style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787e; font-size: 15px; line-height: 18px; padding: 10px 0; text-align: right;">{{ number_format($order->vat, 2) }}</td>
													</tr>
													<tr>
														<td style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787e; font-size: 15px; line-height: 18px; padding: 10px 0; ">
														Payment method</td>
														<td style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787e; font-size: 15px; line-height: 18px; padding: 10px 0; text-align: right;">
															{{ $order->payment_method }}
														</td>
													</tr>
													<tr>
														<td style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787e; font-size: 15px; line-height: 18px; padding: 10px 0; ">
														Total</td>
														<td style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787e; font-size: 15px; line-height: 18px; padding: 10px 0; text-align: right;">{{ config('adinkra.currency_code') }}{{ number_format($order->grand_total, 2) }}</td>
													</tr>
												</tr>
											</tbody>
										</table>
									</div>


									<table class="panel" width="100%" cellpadding="0" cellspacing="0" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; margin: 0 0 21px;  border-left:0; " >
										<tr>
											<td class="panel-content" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; background-color: #edeff2; padding: 16px;">
												<table width="100%" cellpadding="0" cellspacing="0" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">
													<tr>
														<td class="panel-item" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; padding: 0;">
															<p style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787e; font-size: 16px; line-height: 1.5em; margin-top: 0; text-align: center; margin-bottom: 0; padding-bottom: 0;">{{getCustomLocalTime($order->created_at)}}</p>
														</td>
													</tr>
												</table>
											</td>
										</tr>
									</table>



									<p style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787e; font-size: 16px; line-height: 1.5em; margin-top: 0; text-align: left;">kind regards,<br>
										{{ config('app.name') }}
									</p>

									<table class="subcopy" width="100%" cellpadding="0" cellspacing="0" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; border-top: 1px solid #edeff2; margin-top: 25px; padding-top: 25px;"><tr>
										<td style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">
											<p style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787e; line-height: 1.5em; margin-top: 0; text-align: left; font-size: 12px;">You are receiving this email because and order was placed on {{ config('app.name') }}. Disregard this email if you are not the intended reciepient</p>
										</td>
									</tr></table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				
				<!-- footer -->
				<tr>
					<td style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">
						<table class="footer" align="center" width="570" cellpadding="0" cellspacing="0" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; margin: 0 auto; padding: 0; text-align: center; width: 570px; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 570px;"><tr>
							<td class="content-cell" align="center" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; padding: 35px;">
								<p style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; line-height: 1.5em; margin-top: 0; color: #aeaeae; font-size: 12px; text-align: center;">&copy; {{date('Y')}} <a href="{{ config('app.url') }}">{{ config('app.name') }}</a>. All rights reserved.</p>
							</td>
						</tr></table>
					</td>
				</tr>
			</table>
		</td>
	</tr></table>
</body>
</html>