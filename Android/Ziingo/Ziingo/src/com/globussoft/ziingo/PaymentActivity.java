package com.globussoft.ziingo;

import java.math.BigDecimal;
import java.util.HashMap;
import java.util.Map;

import org.json.JSONObject;

import android.app.Activity;
import android.content.Intent;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.ImageView;
import android.widget.RelativeLayout;
import android.widget.Toast;

import com.android.volley.AuthFailureError;
import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.globussoft.ziingo.utills.ConstantUrl;
import com.globussoft.ziingo.utills.PaypalConfig;
import com.globussoft.ziingo.utills.Singleton;
import com.paypal.android.sdk.payments.PayPalConfiguration;
import com.paypal.android.sdk.payments.PayPalPayment;
import com.paypal.android.sdk.payments.PayPalService;
import com.paypal.android.sdk.payments.PaymentConfirmation;

public class PaymentActivity extends Activity {

	RelativeLayout rel_paypal, rel_cod;
	ImageView make_payment, bkbtn;

	private static PayPalConfiguration config = new PayPalConfiguration().environment(PayPalConfiguration.ENVIRONMENT_SANDBOX)
												.clientId(PaypalConfig.PAYPAL_CLIENT_ID);


	PaymentConfirmation confirm;
	private static final int REQUEST_CODE_PAYMENT = 0;

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		// TODO Auto-generated method stub
		super.onCreate(savedInstanceState);
		setContentView(R.layout.payment);
		InitUI();
	}

	public void InitUI() {
		rel_paypal = (RelativeLayout) findViewById(R.id.rel_paypal);
		rel_cod = (RelativeLayout) findViewById(R.id.rel_cod);
		// make_payment = (ImageView) findViewById(R.id.make_pay_btn);
		bkbtn = (ImageView) findViewById(R.id.del_pay_btn);

		bkbtn.setOnClickListener(new OnClickListener() {

			public void onClick(View v) {
				// TODO Auto-generated method stub

				onBackPressed();

			}
		});
		
		//config.acceptCreditCards(true);

		Intent intent = new Intent(PaymentActivity.this, PayPalService.class);
		intent.putExtra(PayPalService.EXTRA_PAYPAL_CONFIGURATION, config);
		startService(intent);

		rel_paypal.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub
				PayPalPayment payment = new PayPalPayment(new BigDecimal(
						Singleton.cart_total_amt), "USD", "Total Amount", PayPalPayment.PAYMENT_INTENT_SALE);

				Intent intent = new Intent(PaymentActivity.this,
						com.paypal.android.sdk.payments.PaymentActivity.class);

				// send the same configuration for restart resiliency
				intent.putExtra(PayPalService.EXTRA_PAYPAL_CONFIGURATION, config);
				intent.putExtra(com.paypal.android.sdk.payments.PaymentActivity.EXTRA_PAYMENT,payment);			

				startActivityForResult(intent, REQUEST_CODE_PAYMENT);
			}
		});
		
		rel_cod.setOnClickListener(new OnClickListener() {
			
			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub
				
				Intent i = new Intent(PaymentActivity.this, PhoneVerificationActivity.class);
				startActivity(i);
				
			}
		});

	}

	@Override
	public void onActivityResult(int requestCode, int resultCode, Intent data) {

		if (requestCode == REQUEST_CODE_PAYMENT) {
			
			if (resultCode == Activity.RESULT_OK) {
				
				confirm = data.getParcelableExtra(com.paypal.android.sdk.payments.PaymentActivity.EXTRA_RESULT_CONFIRMATION);

				if (confirm != null) {
					

					Log.i("paymentExample", confirm.toJSONObject().toString());

					// TODO: send 'confirm' to your server for verification.
					// see
					// https://developer.paypal.com/webapps/developer/docs/integration/mobile/verify-mobile-payment/
					// for more details.

					String paymentID = confirm.getProofOfPayment().getPaymentId();
					String paymentClient = confirm.getPayment().toString();
					String transactionID = confirm.getProofOfPayment().getTransactionId();
					String state = confirm.getProofOfPayment().getState();
					String createTime = confirm.getProofOfPayment().getCreateTime();

					System.out.println("paymentID == " + paymentID);
					System.out.println("payment_client == " + paymentClient);
					System.out.println("state == " + state);
					System.out.println("createTime == " + createTime);
					System.out.println("transactionID == " + transactionID);

					System.out.println("getProofOfPayment() = "+ confirm.getProofOfPayment());
					System.out.println("getTransactionId = "+ confirm.getProofOfPayment().getTransactionId());

					GetTransactionID(Singleton.order_id, "2", paymentID, Singleton.cart_total_amt, Singleton.user_id, Singleton.date, state );

					
					
				}
			} else if (resultCode == Activity.RESULT_CANCELED) {
				Log.i("paymentExample", "The user canceled.");
			} else if (resultCode == com.paypal.android.sdk.payments.PaymentActivity.RESULT_EXTRAS_INVALID) {
				Log.i("paymentExample", "An invalid Payment or PayPalConfiguration was submitted. Please see the docs.");
			}
		}

	}
	
	public void GetTransactionID(final String order_id, final String type, final String paymentID, final String cart_total_amt, 
			final String user_id, final String date, final String state)
	{
	
		RequestQueue queue = Volley.newRequestQueue(getApplicationContext());
		StringRequest sr = new StringRequest(Request.Method.POST,
				ConstantUrl.Url_main+ ConstantUrl.Url_inserttransaction, new Response.Listener<String>() {
					@Override
					public void onResponse(String response) {

						try {
							JSONObject json = new JSONObject(response);

							System.out.println("Transaction response"+ response);

							String msg = json.getString("message");

							System.out.println("message >>>>>>>>>" + msg);

							if (json.getString("code").equals("200")) {

								JSONObject jsonMainobj = json.getJSONObject("data");								

								Singleton.transaction_id = jsonMainobj.getString("transaction_id");							

								System.out.println("Singleton.transaction_id == "+ Singleton.transaction_id);
								
								System.out.println("************* Order placed SUCCESSFULLY ***************");
								
							}

							else {

								Toast.makeText(getApplicationContext(), msg, Toast.LENGTH_LONG).show();
							}

						} catch (Exception e) {
							e.printStackTrace();
						}					

					}

				}, new Response.ErrorListener() {
					@Override
					public void onErrorResponse(VolleyError error) {
						// VolleyLog.d(TAG, "Error: " + error.getMessage());
						System.out.println("Error : " + error);
						// hidePDialog();

					}
				}) {

			@Override
			protected Map<String, String> getParams() {
				Map<String, String> params = new HashMap<String, String>();
				params.put("order_id", order_id);
				params.put("transactiontype", type);
				params.put("amount", cart_total_amt);
				params.put("transactioncode", paymentID);
				params.put("userid", user_id);
				params.put("date", date);
				params.put("status", state);

				return params;
			}

			@Override
			public Map<String, String> getHeaders() throws AuthFailureError {
				Map<String, String> params = new HashMap<String, String>();
				params.put("Content-Type", "application/x-www-form-urlencoded");
				return params;
			}

		};

		queue.add(sr);
	
		
	}
	
	@Override
	public void onDestroy()
	{
		stopService(new Intent(PaymentActivity.this, PayPalService.class));
		super.onDestroy();
	}

	@Override
	public void onDetachedFromWindow()
	{
		super.onDetachedFromWindow();
	}


}
