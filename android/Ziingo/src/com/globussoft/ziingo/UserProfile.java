package com.globussoft.ziingo;

import java.util.HashMap;
import java.util.Map;

import org.json.JSONException;
import org.json.JSONObject;

import android.app.Activity;
import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.content.SharedPreferences.Editor;
import android.os.Bundle;
import android.telephony.TelephonyManager;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.AdapterView;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.Spinner;
import android.widget.Toast;
import android.widget.AdapterView.OnItemSelectedListener;

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

public class UserProfile extends Activity implements
OnItemSelectedListener {

	// ConnectionDetector cd;

	EditText firstName, lastName, address, city, state, country, phone;
	ImageView bck_btn;
	Spinner cntry_code;
	
	SharedPreferences pref;
	Editor editor;
	int PRIVATE_MODE = 0;

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		// TODO Auto-generated method stub
		super.onCreate(savedInstanceState);
		setContentView(R.layout.user_profile);

		details();
	}

	protected void sharedPrefernces() {
		
		pref = getSharedPreferences("Ziingo", MODE_PRIVATE);
		editor = pref.edit();
	    editor.putString("firstName", Singleton.firstName);
		editor.putString("lastName", Singleton.lastName);
		//editor.putString("address", Singleton.user_address);
		editor.putString("city", Singleton.cityName);
		editor.putString("state", Singleton.stateName);
		editor.putString("country", Singleton.countryName);
		editor.putString("country_code", Singleton.CountryCode);
		editor.putString("phone", Singleton.phone);
		editor.commit();

		System.out.println("******** Shared Preference ********");
		System.out.println("firstName "+ Singleton.firstName);
		System.out.println("lastName "+ Singleton.lastName);
		//System.out.println("address "+ Singleton.user_address);
		System.out.println("city "+ Singleton.cityName);
		System.out.println("state "+ Singleton.stateName);
		System.out.println("country "+ Singleton.countryName);
		System.out.println("phone "+ Singleton.phone);
		System.out.println("******** ******** ******** ********");
	}

	private void details() {
		firstName = (EditText) findViewById(R.id.firstname);
		lastName = (EditText) findViewById(R.id.lastname);
		//address = (EditText) findViewById(R.id.address);
		cntry_code = (Spinner) findViewById(R.id.pr_cntry_code);
		phone = (EditText) findViewById(R.id.ph_num1);
		city = (EditText) findViewById(R.id.city);
		state = (EditText) findViewById(R.id.state);
		country = (EditText) findViewById(R.id.country);
		bck_btn = (ImageView) findViewById(R.id.up_bkbtn);

		ImageView save = (ImageView) findViewById(R.id.save);
		
		cntry_code.setOnItemSelectedListener(new OnItemSelectedListener() {

			@Override
			public void onItemSelected(AdapterView<?> parent, View view,
					int position, long id) {
				// TODO Auto-generated method stub

				Singleton.CountryCode = parent.getItemAtPosition(position).toString();
				System.out.println("CountryCode : " + Singleton.CountryCode);

			}

			@Override
			public void onNothingSelected(AdapterView<?> parent) {
				// TODO Auto-generated method stub

			}
		});

		save.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View v) {

				if (new ConnectionDetector(getApplicationContext()).isConnectingToInternet()) {
					if (firstName.getText().toString().length() > 1
							&& lastName.getText().toString().length() != 0
							//&& address.getText().toString().length() > 1
							&& phone.getText().toString().length() > 1
							&& city.getText().toString().length() > 1
							&& state.getText().toString().length() > 1
							&& country.getText().toString().length() > 1)

					{
						
						Singleton.firstName = firstName.getText().toString();  // fn, ln, phone
						Singleton.lastName = lastName.getText().toString();
						//Singleton.user_address = address.getText().toString();
						//Singleton.phone = GetCountryZipCode(getApplicationContext()) + phone.getText().toString();
						Singleton.phone = phone.getText().toString();
						Singleton.user_city = city.getText().toString();
						Singleton.user_state = state.getText().toString();
						Singleton.user_country = country.getText().toString();
						
					 System.out.println("profile >>> Singleton.user_id ==== "+Singleton.user_id);	
					 
					 System.out.println("Country code >> "+ Singleton.CountryCode);

						userData(Singleton.user_id, Singleton.firstName, Singleton.lastName,
								 Singleton.phone, Singleton.user_city,
								Singleton.user_state, Singleton.user_country, Singleton.CountryCode);					
						
						

					} else {
						Toast.makeText(getApplicationContext(),
								"Fill all the details", Toast.LENGTH_LONG)
								.show();
					}

				} else {
					Toast.makeText(getApplicationContext(),
							"Connect to Internet", Toast.LENGTH_LONG).show();
				}

			}

		});
		
		bck_btn.setOnClickListener(new OnClickListener() {
			
			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub
				 onBackPressed();
			}
		});

	}
	
	public String GetCountryZipCode(Context context) {
		  String CountryID = "";
		  String CountryZipCode = "";

		  TelephonyManager manager = (TelephonyManager) context
		    .getSystemService(Context.TELEPHONY_SERVICE);
		  // getNetworkCountryIso
		  CountryID = manager.getSimCountryIso().toUpperCase();
		  String[] rl = context.getResources().getStringArray(
		    R.array.CountryCodes);
		  for (int i = 0; i < rl.length; i++) {
		   String[] g = rl[i].split(",");
		   if (g[1].trim().equals(CountryID.trim())) {
		    CountryZipCode = g[0];
		    break;
		   }
		  }
		  return CountryZipCode;
		 }

	private void userData(final String user_id, final String firstName,
			final String lastName,  final String phone,
			final String city, final String state, final String country, final String country_code) {
	
		RequestQueue queue = Volley.newRequestQueue(getApplicationContext());
		
		System.out.println("*************");
		
		StringRequest sr = new StringRequest(Request.Method.POST,
				ConstantUrl.Url_main + ConstantUrl.Url_userprofileinfo,
				new Response.Listener<String>() {
					
					@Override
					public void onResponse(String response) {
						
						System.out.println("@@@@@@@@@@@@@@@@@@@@@@@@@");

						System.out.println("UserProfile response" + response);

						try {
							JSONObject json = new JSONObject(response);

							String msg = json.getString("message");

							if (json.getString("code").equals("200")) {

								//JSONObject obj = json.getJSONObject("data");

								System.out.println("message >>>>>>>>>" + msg);

								Toast.makeText(getApplicationContext(), msg,
										Toast.LENGTH_LONG).show();

								System.out.println("Successfully SAVED ");
								
								sharedPrefernces();
								
							Intent intent = new Intent(getApplicationContext(),Choose_spinner_country.class);
								startActivity(intent);

								//finish();

							}

							else {

								Toast.makeText(getApplicationContext(), msg,
										Toast.LENGTH_LONG).show();
							}

						} catch (Exception e) {
							e.printStackTrace();
						}

					}
					
					
				}, new Response.ErrorListener() {
					@Override
					public void onErrorResponse(VolleyError error) {

					}
				}) {
			@Override
			protected Map<String, String> getParams() {
				Map<String, String> params = new HashMap<String, String>();
				params.put("userid", user_id);
				params.put("firstname", firstName);
				params.put("lastname", lastName);
				//params.put("address", address);
				params.put("phone", phone);
				params.put("city", city);
				params.put("state", state);
				params.put("country", country);
				params.put("contactcountrycode", country_code);

				System.out.println("user_id = "+ user_id);
				System.out.println("firstName = "+ firstName);
				System.out.println("lastName = "+ lastName);
				//System.out.println("address = "+ address);
				System.out.println("phone = "+ phone);
				System.out.println("city = "+ city);
				System.out.println("state = "+ state);
				System.out.println("country = "+ country);		
				System.out.println("contactcountrycode = "+ country_code);
				
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
	public void onItemSelected(AdapterView<?> parent, View view, int position,
			long id) {
		// TODO Auto-generated method stub
		
		Singleton.CountryCode = parent.getItemAtPosition(position)
				.toString();
		
	}

	@Override
	public void onNothingSelected(AdapterView<?> parent) {
		// TODO Auto-generated method stub
		
	}

}
