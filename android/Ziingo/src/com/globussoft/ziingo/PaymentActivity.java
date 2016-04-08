package com.globussoft.ziingo;

import java.math.BigDecimal;
import java.sql.Timestamp;
import java.text.SimpleDateFormat;
import java.util.Date;
import java.util.HashMap;
import java.util.Locale;
import java.util.Map;
import java.util.TimeZone;

import org.json.JSONArray;
import org.json.JSONObject;

import android.app.Activity;
import android.content.Intent;
import android.content.SharedPreferences;
import android.content.SharedPreferences.Editor;
import android.os.Bundle;
import android.util.Base64;
import android.util.Log;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.ImageView;
import android.widget.RelativeLayout;
import android.widget.Toast;

import com.android.volley.AuthFailureError;
import com.android.volley.DefaultRetryPolicy;
import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.globussoft.ziingo.utills.ConstantUrl;
import com.globussoft.ziingo.utills.PaypalConfig;
import com.globussoft.ziingo.utills.Singleton;
import com.google.gson.JsonObject;
import com.paypal.android.sdk.payments.PayPalConfiguration;
import com.paypal.android.sdk.payments.PayPalPayment;
import com.paypal.android.sdk.payments.PayPalService;
import com.paypal.android.sdk.payments.PaymentConfirmation;

public class PaymentActivity extends Activity {

	RelativeLayout rel_paypal, rel_cod;
	ImageView make_payment, bkbtn;
	
	private static PayPalConfiguration config = new PayPalConfiguration()
									.environment(PayPalConfiguration.ENVIRONMENT_SANDBOX)
									.clientId(PaypalConfig.PAYPAL_CLIENT_ID);

	PaymentConfirmation confirm;
	
	SharedPreferences pref;
	Editor editor;
	
	String createTime, status, transactionID, paymentClient;
	
	private static final int REQUEST_CODE_PAYMENT = 0;

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		// TODO Auto-generated method stub
		super.onCreate(savedInstanceState);
		setContentView(R.layout.payment);
		InitUI();
	}
	
	protected void sharedPrefernces() 
	{
		pref = getSharedPreferences("Ziingo", MODE_PRIVATE);
		editor = pref.edit();

		editor.putString("order_timeStamp", Singleton.timestamp);	
		editor.putString("transaction_id", Singleton.transaction_id);
		editor.commit();
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
		

		Intent intent = new Intent(PaymentActivity.this, PayPalService.class);
		intent.putExtra(PayPalService.EXTRA_PAYPAL_CONFIGURATION, config);
		startService(intent);

		config.acceptCreditCards(true);
		
		System.out.println("config.getLibraryVersion() >> "+ config.getLibraryVersion());		
		
		rel_paypal.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View v) 
			{
				// TODO Auto-generated method stub
								
				PayPalPayment payment = new PayPalPayment(new BigDecimal(Singleton.cart_total_amt), "USD", "Total Amount",PayPalPayment.PAYMENT_INTENT_SALE);

				Intent intent = new Intent(PaymentActivity.this, com.paypal.android.sdk.payments.PaymentActivity.class);

				// send the same configuration for restart resiliency
				intent.putExtra(PayPalService.EXTRA_PAYPAL_CONFIGURATION, config);

				intent.putExtra(com.paypal.android.sdk.payments.PaymentActivity.EXTRA_PAYMENT, payment);

				startActivityForResult(intent, 0);
				
			}
		});
		
		rel_cod.setOnClickListener(new OnClickListener() {
			
			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub
				
				/*Intent i = new Intent(PaymentActivity.this, PhoneVerificationActivity.class);
				startActivity(i);*/
				
				Intent i = new Intent(PaymentActivity.this, OrderConfirmActivity.class);
				startActivity(i);
				
				finish();
				
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

				     Singleton.payment_ID = confirm.getProofOfPayment().getPaymentId();
					 paymentClient = confirm.getPayment().toString();
					 transactionID = confirm.getProofOfPayment().getTransactionId();
					 status = confirm.getProofOfPayment().getState();	
					 createTime = confirm.getProofOfPayment().getCreateTime();					
					
					
					SimpleDateFormat dateFormat = new SimpleDateFormat("MM/dd/yyyy HH:mm:ss", Locale.getDefault());
					dateFormat.setTimeZone(TimeZone.getTimeZone("GMT"));
					Date date = new Date();	
					Timestamp ts = new Timestamp(date.getTime());					
					Singleton.timestamp = ts.toString();
					
					System.out.println("Singleton.timestamp == "+Singleton.timestamp);		


					System.out.println("paymentID == " + Singleton.payment_ID);
					System.out.println("payment_client == " + paymentClient);
					System.out.println("state == " + status);
					System.out.println("createTime == " + createTime);
					System.out.println("transactionID == " + transactionID);

					System.out.println("getProofOfPayment() = "+ confirm.getProofOfPayment());
					System.out.println("getTransactionId = "+ confirm.getProofOfPayment().getTransactionId());
					
					GetAccessToken(PaypalConfig.PAYPAL_CLIENT_ID , PaypalConfig.PAYPAL_CLIENT_SECRET);
					
				//	Pay(Singleton.order_id, "2", Singleton.payment_ID, Singleton.cart_total_amt, 
			    //		Singleton.user_id, Singleton.timestamp, status );

				}
			} 
			else if (resultCode == Activity.RESULT_CANCELED) 
			{
				Log.i("paymentExample", "The user canceled.");
			} 
			else if (resultCode == com.paypal.android.sdk.payments.PaymentActivity.RESULT_EXTRAS_INVALID) 
			{
				Log.i("paymentExample", "An invalid Payment or PayPalConfiguration was submitted. Please see the docs.");
			}
		}

	}
	
	private void Pay(final String order_id, final String type, final String paymentID, final String cart_total_amt, 
			final String user_id, final String date, final String status)
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
								
								sharedPrefernces();
								
								Intent i = new Intent(PaymentActivity.this, OrderConfirmActivity.class);
								startActivity(i);
								
								//finish();
								
							}

							else 
							{
								Toast.makeText(getApplicationContext(), msg, Toast.LENGTH_LONG).show();
							}

						} 
						catch (Exception e) 
						{
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
				}) 
		
		{
			@Override
			protected Map<String, String> getParams() {
				Map<String, String> params = new HashMap<String, String>();
				params.put("order_id", order_id);
				params.put("transactiontype", type);
				params.put("amount", cart_total_amt);
				params.put("transactioncode", paymentID);
				params.put("userid", user_id);
				params.put("date", date);
				params.put("status", status);

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
	
	private void GetAccessToken(final String client_id, final String client_secret)
	{	
		System.out.println("*******");
	
		RequestQueue queue = Volley.newRequestQueue(getApplicationContext());
		
		StringRequest sr = new StringRequest(Request.Method.POST,
				"https://api.sandbox.paypal.com/v1/oauth2/token", new Response.Listener<String>() 
				{			
					@Override
					public void onResponse(String response) {
						
						System.out.println("**   ****  **");
						
						try {
							
							JSONObject json = new JSONObject(response);
							
							System.out.println("Access token Response :: "+ response);
							
							Singleton.access_token = json.getString("access_token");
							
							Singleton.token_type = json.getString("token_type");

						} 
						catch (Exception e) 
						{
							e.printStackTrace();
						}
						
						System.out.println("access_token ::: "+ Singleton.access_token);
						System.out.println("token_type ::: "+ Singleton.token_type);
						
						getTranactionID(Singleton.access_token, Singleton.token_type);

					}

				}, new Response.ErrorListener() {
					@Override
					public void onErrorResponse(VolleyError error) {
						// VolleyLog.d(TAG, "Error: " + error.getMessage());
						System.out.println("Error : " + error);
						
						Toast.makeText(getApplicationContext(), "Payment  failed !", Toast.LENGTH_SHORT).show();
						// hidePDialog();
					}
				}) 
		
		{
			@Override
			protected Map<String, String> getParams() {
				
				Map<String, String> params = new HashMap<String, String>();
				
				params.put("grant_type", "client_credentials");			

				return params;
			}
			
			
			/*@Override
			   public Map<String, String> getHeaders() throws AuthFailureError {
			    HashMap<String, String> params = new HashMap<String, String>();
			    String creds = String.format("%s:%s", client_id,
			    		client_secret);
			    String auth = "Basic "
			      + Base64.encodeToString(creds.getBytes(),
			        Base64.DEFAULT);
			    params.put("Authorization", auth);
			    return params;
			   }*/
			
			@Override
			public Map<String, String> getHeaders() throws AuthFailureError {
			    HashMap<String, String> params = new HashMap<String, String>();
			    String creds = client_id+":"+client_secret;
			    String auth = "Basic " + Base64.encodeToString(creds.getBytes(), Base64.DEFAULT);
			    params.put("Authorization", auth);
			    params.put("Accept", "application/json");
			    params.put("Accept-Language", "en_US");
			    params.put("Content-Type", "application/x-www-form-urlencoded");
			    return params;
			}

		};
	//	sr.setRetryPolicy(new DefaultRetryPolicy(0, 0, 0));
		
		sr.setRetryPolicy(new DefaultRetryPolicy(5*DefaultRetryPolicy.DEFAULT_TIMEOUT_MS, 0, 0));
		sr.setRetryPolicy(new DefaultRetryPolicy(0, 0, 0));
		
		queue.add(sr);
	}
	
	private void getTranactionID(final String token_type, final String access_token)
	{	
		RequestQueue queue = Volley.newRequestQueue(getApplicationContext());
		
		StringRequest sr = new StringRequest(Request.Method.GET,
				"https://api.sandbox.paypal.com/v1/payments/payment/"+Singleton.payment_ID, new Response.Listener<String>() {
					@Override
					public void onResponse(String response) {

						try {
							JSONObject json = new JSONObject(response);
							System.out.println("getTranactionID response :: "+ response);	
							
							JSONArray jarr = json.getJSONArray("transactions");
							
							JSONObject json1 =jarr.getJSONObject(0);
							
							JSONArray jarr1 = json1.getJSONArray("related_resources");						
							
							JSONObject json2 = jarr1.getJSONObject(0);
							
							JSONObject json3 = json2.getJSONObject("sale");
							
							Singleton.transaction_id = json3.getString("id");
							
							System.out.println("Singleton.transaction_id >>> "+Singleton.transaction_id);					
							
						} 
						catch (Exception e) 
						{
							e.printStackTrace();
						}
						
						Pay(Singleton.order_id, "2", Singleton.transaction_id, Singleton.cart_total_amt, 
								Singleton.user_id, Singleton.timestamp, status );

					}

				}, new Response.ErrorListener() {
					@Override
					public void onErrorResponse(VolleyError error) {
						// VolleyLog.d(TAG, "Error: " + error.getMessage());
						System.out.println("Error : " + error);
						// hidePDialog();

					}
				}) 
		
		{
			@Override
			protected Map<String, String> getParams() {
				Map<String, String> params = new HashMap<String, String>();
				//params.put("grant_type", "client_credentials");			

				return params;
			}
			
			@Override
			public Map<String, String> getHeaders() throws AuthFailureError {
			    HashMap<String, String> params = new HashMap<String, String>();
			   
			    params.put("Authorization", token_type+" "+access_token);
			    params.put("Content-Type", "application/json");
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
