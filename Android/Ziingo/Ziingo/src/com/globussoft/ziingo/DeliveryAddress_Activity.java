package com.globussoft.ziingo;

import java.lang.reflect.Array;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import com.android.volley.AuthFailureError;
import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.globussoft.ziingo.utills.ConnectionDetector;
import com.globussoft.ziingo.utills.ConstantUrl;
import com.globussoft.ziingo.utills.Singleton;

import android.app.Activity;
import android.app.AlertDialog;
import android.content.Intent;
import android.content.SharedPreferences;
import android.content.SharedPreferences.Editor;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.view.View.OnClickListener;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.Toast;

public class DeliveryAddress_Activity extends Activity {
	
	SharedPreferences pref;
	Editor editor;
	int PRIVATE_MODE = 0;
	
	EditText del_fn, del_ph, del_add, del_lndmrk, del_city, del_state;
	ImageView del_fn_ed, del_ph_ed, del_add_ed, del_lndmrk_ed, del_city_ed, del_state_ed, del_palce_order_btn, bckbtn;

	@Override
	public void onCreate(Bundle savedInstanceState) {

		super.onCreate(savedInstanceState);
		setContentView(R.layout.delivery_add);
		InitDelUI();
		
	}
	
	protected void sharedPrefernces() {
		pref = getSharedPreferences("Login Credentials", MODE_PRIVATE);
		editor = pref.edit();
		
		editor.putString("delivery_fn", Singleton.delFirstname);
		editor.putString("delivery_ph", Singleton.delPh_num);
		editor.putString("delivery_address", Singleton.delAddress);
		editor.putString("delivery_landmark", Singleton.delLandMark);
		//editor.putString("delivery_city", Singleton.delCity);   // change to spinner_City
		//editor.putString("delivery_state", Singleton.delState); //  change to spinner_City
		//editor.putString("delivery_country", Singleton.countryName);// 
		editor.putString("ordered_product_ids", Singleton.ordered_product_ids.toString());
		editor.putString("order_id", Singleton.order_id);
		editor.putString("delivery_id", Singleton.delivery_id);	

		editor.commit();

		System.out.println("******** Shared Preference ********");		
		System.out.println("order_id " + Singleton.order_id);
		System.out.println("delivery_id " + Singleton.delivery_id);
		System.out.println("ordered_product_ids " +Singleton.ordered_product_ids);
		System.out.println("******** ******** ******** ********");
	}

	public void InitDelUI() {

		del_fn     = (EditText) findViewById(R.id.del_firstname);
		del_ph     = (EditText) findViewById(R.id.ph_num);
		del_add    = (EditText) findViewById(R.id.del_address);
		del_lndmrk = (EditText) findViewById(R.id.del_landmark);
	  //del_city   = (EditText) findViewById(R.id.delcity);
	  //del_state  = (EditText) findViewById(R.id.delstate);
		bckbtn     = (ImageView) findViewById(R.id.del_bk_btn);
		del_fn_ed  = (ImageView) findViewById(R.id.del_fn_edit);
		del_ph_ed  = (ImageView) findViewById(R.id.del_ph_edit);
		del_add_ed = (ImageView) findViewById(R.id.del_add_edit);
		
		del_lndmrk_ed = (ImageView) findViewById(R.id.del_lndmrk_edit);
	  //del_city_ed   = (ImageView) findViewById(R.id.del_city_edit);
	  //del_state_ed  = (ImageView) findViewById(R.id.del_state_edit);		
		del_palce_order_btn = (ImageView) findViewById(R.id.del_save);
		
		
		bckbtn.setOnClickListener(new OnClickListener() {
			
			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub
				onBackPressed();
			}
		});
		
		del_palce_order_btn.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub
				
				if (Singleton.firstName != null) 
				{					
					Singleton.delFirstname = Singleton.firstName +" "+ Singleton.lastName;
					del_fn.setText(Singleton.delFirstname);
					System.out.println("Singleton.delFirstname = Singleton.firstName = "+ Singleton.delFirstname);
				} 
				else 
				{
					Singleton.delFirstname = del_fn.getText().toString();
					System.out.println("Singleton.delFirstname == "+Singleton.delFirstname);

				}

				if (Singleton.phone != null) 
				{
					del_ph.setText(Singleton.phone);
					Singleton.delPh_num = Singleton.phone;
					System.out.println("Singleton.delPh_num = Singleton.phone = "+ Singleton.delPh_num);
				} 
				else 
				{
					Singleton.delPh_num = del_ph.getText().toString();
					System.out.println("Singleton.delPh_num == "+Singleton.delPh_num);

				}

				if (Singleton.user_address != null) 
				{
					del_add.setText(Singleton.user_address);
					Singleton.delAddress = Singleton.user_address;
					System.out.println("Singleton.delAddress = Singleton.user_address = "+ Singleton.delAddress);
				} 
				else 
				{					
					Singleton.delAddress = del_add.getText().toString();
					System.out.println("Singleton.delAddress =="+ Singleton.delAddress);

				}
				
				Singleton.delLandMark = del_lndmrk.getText().toString();
				System.out.println("Singleton.delLandMark =="+ Singleton.delLandMark);
				
				/*if (Singleton.user_city != null) {
					del_city.setText(Singleton.user_city);
					Singleton.delCity = Singleton.user_city;
					System.out
							.println("Singleton.delCity = Singleton.user_city = "
									+ Singleton.delCity);
				} else {
					
					Singleton.delCity = del_city.getText().toString();

				}*/
				
				/*if (Singleton.user_state != null) {
					del_state.setText(Singleton.user_state);
					Singleton.delState = Singleton.user_state;
					System.out
							.println("Singleton.delState = Singleton.user_state = "
									+ Singleton.delState);
				} else {
					
					Singleton.delState = del_state.getText().toString();

				}*/


				if (new ConnectionDetector(getApplicationContext())
						.isConnectingToInternet()) 
				{
					if (del_fn.getText().toString().length() !=0
							&& del_ph.getText().toString().length() !=0
							&& del_lndmrk.getText().toString().length() !=0
							&& del_add.getText().toString().length() !=0
							)

					{						
						insertDelAdd(Singleton.user_id, Singleton.delFirstname, Singleton.delPh_num, Singleton.delAddress, 
									 Singleton.Spn_CityName, Singleton.Spn_StateName, Singleton.Spn_CountryName, Singleton.delLandMark,
									 Singleton.product_cartid);
						
						Intent i = new Intent(DeliveryAddress_Activity.this, PaymentActivity.class);
						startActivity(i);

					}
					else 
					{
						Toast.makeText(getApplicationContext(), "Fill all the details",
								Toast.LENGTH_LONG).show();
					}

				} 
				else 
				{
					Toast.makeText(getApplicationContext(), "Connect to Internet",
							Toast.LENGTH_LONG).show();
				}

			}

		});

		del_fn_ed.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub

				del_fn.setText(null);

			}
		});

		del_ph_ed.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub

				del_ph.setText(null);

			}
		});

		del_add_ed.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub				
				
				del_add.setText(null);

			}
		});
		
		del_lndmrk_ed.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub			
				
				del_lndmrk.setText(null);

			}
		});
		
		/*del_city_ed.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub				
				
				del_city.setText(null);

			}
		});
		
		del_state_ed.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub				
				
				del_state.setText(null);

			}
		});*/
		
	}
	 
	public void insertDelAdd(final String user_id, final String delFirstname, final String delPh_num, final String delAddress, 
			final String cityName, final String stateName, final String countryName, final String delLandMark,
			 final List<String> product_cartid ){
		
		System.out.println("user_id = "+ user_id);
		System.out.println("cityName = "+ cityName);
		System.out.println("stateName = "+ stateName);
		System.out.println("countryName = "+ countryName);
	  //System.out.println("del_time = "+ del_time);
		System.out.println("cart_id = "+ product_cartid);		


		RequestQueue queue = Volley.newRequestQueue(getApplicationContext().getApplicationContext());
		StringRequest sr = new StringRequest(Request.Method.POST,
				ConstantUrl.Url_main + ConstantUrl.Url_insertorders,
				new Response.Listener<String>() {
					@Override
					public void onResponse(String response) {

						try {

							System.out.println(">>>>>>>>>>>>>");

							JSONObject json = new JSONObject(response);

							System.out.println("Delivery address REsponse:  " + response);

							String msg = json.getString("message");

							System.out.println("message >>>>>>>>>" + msg);

							if (json.getString("code").equals("200")) {

								JSONObject data = json.getJSONObject("data");
								 
								Singleton.order_id = data.getString("order_id");
								Singleton.delivery_id = data.getString("delivery_id");	
								
								//String ordered_product_ids = data.getString("ordered_product_ids");
								//System.out.println("ordered_product_ids : "+ ordered_product_ids);								
								
								JSONArray ordered_product_ids= data.getJSONArray("ordered_product_ids");
								
								for (int j = 0; j < ordered_product_ids.length(); j++) {
									
									Singleton.ordered_product_ids.add(ordered_product_ids.getString(j));
									
								}
								
								System.out.println("Singleton.ordered_product_ids : "+ ordered_product_ids);
								
								Toast.makeText(getApplicationContext().getApplicationContext(),"Delivery address SAVED",
										Toast.LENGTH_SHORT).show();		
								
								sharedPrefernces() ;
								
							}

							else {

								Toast.makeText(getApplicationContext().getApplicationContext(),
										msg, Toast.LENGTH_SHORT).show();
							}

						} catch (JSONException e) {
							// TODO Auto-generated catch block
							e.printStackTrace();
						}

						//notifyDataSetChanged();

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
				
				/*Map<String, List<String>> listParams = new HashMap<String, List<String>>();
				listParams.put("cart_id", product_cartid);*/
				
				Map<String, String> params = new HashMap<String, String>();
				
				JSONArray a=new JSONArray();
				
				for (int i = 0; i < product_cartid.size(); i++) {
					
					a.put(product_cartid.get(i));
				}
				
				params.put("cartids", a.toString());				
				params.put("userid", user_id);
				params.put("fullname", delFirstname);
				params.put("address", delAddress);
				params.put("phonenum", delPh_num);
				params.put("cityname", cityName);
				params.put("statename", stateName);
				params.put("countryname", countryName);
				params.put("landMark", delLandMark);

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
}
