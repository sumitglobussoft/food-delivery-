package com.globussoft.ziingo;

import java.util.HashMap;
import java.util.List;
import java.util.Map;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import android.app.Activity;
import android.content.Intent;
import android.content.SharedPreferences;
import android.content.SharedPreferences.Editor;
import android.os.Bundle;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.AdapterView;
import android.widget.AdapterView.OnItemSelectedListener;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.Spinner;
import android.widget.TextView;
import android.widget.Toast;

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

public class DeliveryAddress_Activity extends Activity implements OnItemSelectedListener 

{
	EditText del_fn, del_op_add, del_ph, del_add, del_lndmrk, del_pc, del_loc;;
	ImageView del_fn_ed, del_ln_ed, del_ph_ed, del_add_ed, del_lndmrk_ed,
			del_city_ed, del_state_ed, save_btn, bckbtn, del_pc_ed;
	TextView del_city;

	Spinner spn_cntry_code;

	@Override
	public void onCreate(Bundle savedInstanceState) {

		super.onCreate(savedInstanceState);
		setContentView(R.layout.delivery_add);
		InitDelUI();

	}

	public void InitDelUI() {

		del_fn = (EditText) findViewById(R.id.del_firstname);
		del_op_add = (EditText) findViewById(R.id.del_op_add);
		del_ph = (EditText) findViewById(R.id.ph_num);
		del_add = (EditText) findViewById(R.id.del_address);
		del_lndmrk = (EditText) findViewById(R.id.del_landmark);
		del_pc = (EditText) findViewById(R.id.del_pin_cd);
		del_city = (TextView) findViewById(R.id.delcity);
		del_loc = (EditText) findViewById(R.id.del_loc);
		// del_state = (EditText) findViewById(R.id.delstate);
		bckbtn = (ImageView) findViewById(R.id.del_bk_btn);
		del_fn_ed = (ImageView) findViewById(R.id.del_fn_edit);
		del_ln_ed = (ImageView) findViewById(R.id.del_op_add_edit);
		del_ph_ed = (ImageView) findViewById(R.id.del_ph_edit);
		del_add_ed = (ImageView) findViewById(R.id.del_add_edit);
		del_pc_ed = (ImageView) findViewById(R.id.del_pincode_edit);

		del_lndmrk_ed = (ImageView) findViewById(R.id.del_lndmrk_edit);
		del_city_ed = (ImageView) findViewById(R.id.del_city_edit);
		// del_state_ed = (ImageView) findViewById(R.id.del_state_edit);
		save_btn = (ImageView) findViewById(R.id.del_save);
		spn_cntry_code = (Spinner) findViewById(R.id.spn_cntry_code);


		bckbtn.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub
				onBackPressed();
			}
		});
		
		del_fn.setText(Singleton.delFullname);
		del_ph.setText(Singleton.delPh_num);
		del_add.setText(Singleton.delAddress);
		del_op_add.setText(Singleton.delOP_Address);
		del_lndmrk.setText(Singleton.delLandMark);
		del_loc.setText(Singleton.delLoc);
		del_pc.setText(Singleton.delpincode);
		del_city.setText(Singleton.delCity);
		
		
		//del_city.setText(" " + Singleton.Spn_CityName);
		//Singleton.delCity = Singleton.Spn_CityName;		
		

		/*Singleton.delFullname = del_fn.getText().toString();
		Singleton.delOP_Address = del_op_add.getText().toString();
		Singleton.delPh_num = del_ph.getText().toString();
		Singleton.delAddress = del_add.getText().toString();
		Singleton.delLandMark = del_lndmrk.getText().toString();
		Singleton.delpincode = del_pc.getText().toString();
		//Singleton.delCity = del_city.getText().toString();
		Singleton.delLoc = del_loc.getText().toString();*/
		

		spn_cntry_code.setOnItemSelectedListener(new OnItemSelectedListener() {

			@Override
			public void onItemSelected(AdapterView<?> parent, View view,
					int position, long id) {
				// TODO Auto-generated method stub

				Singleton.delCountryCode = parent.getItemAtPosition(position).toString();
				System.out.println("CountryCode : " + Singleton.delCountryCode);

			}

			@Override
			public void onNothingSelected(AdapterView<?> parent) {
				// TODO Auto-generated method stub

			}
		});

		save_btn.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub

				if (new ConnectionDetector(getApplicationContext()).isConnectingToInternet()) 
				{
					if (del_fn.getText().toString().length() != 0
							&& del_ph.getText().toString().length() != 0
							&& del_lndmrk.getText().toString().length() != 0
							&& del_add.getText().toString().length() != 0
							&& del_city.getText().toString().length() != 0
							&& del_pc.getText().toString().length() != 0
							&& del_loc.getText().toString().length() != 0)
					{						
							Singleton.delFullname = del_fn.getText().toString();
							Singleton.delOP_Address = del_op_add.getText().toString();
							Singleton.delPh_num = del_ph.getText().toString();
							Singleton.delAddress = del_add.getText().toString();
							Singleton.delLandMark = del_lndmrk.getText().toString();
							Singleton.delpincode = del_pc.getText().toString();
							Singleton.delLoc = del_loc.getText().toString();

							System.out.println("Singleton.delFullname == "+ Singleton.delFullname);
							System.out.println("Singleton.delPh_num == "+ Singleton.delPh_num);
							System.out.println("Singleton.delAddress == "+ Singleton.delAddress);
							System.out.println("Singleton.delLandMark == "+ Singleton.delLandMark);
							System.out.println("Singleton.delLoc == "+Singleton.delLoc);

							if (Singleton.del_address_ID == null || Singleton.add_new_DelAddress == true) 
							{
								Singleton.add_new_DelAddress = false;
								
								insertDelAdd(Singleton.user_id,
										Singleton.delFullname,
										Singleton.delOP_Address,
										Singleton.delCountryCode,
										Singleton.delPh_num,
										Singleton.delAddress,
										Singleton.delCity,
										Singleton.Spn_StateName,
										Singleton.Spn_CountryName,
										Singleton.delLandMark,
										Singleton.delpincode,
										Singleton.delLoc);
							} 
							else if (Singleton.del_address_ID != null)
							{
								updateDelAdd(Singleton.user_id,
										Singleton.delFullname,
										Singleton.delOP_Address,
										Singleton.delCountryCode,
										Singleton.delPh_num,
										Singleton.delAddress,
										Singleton.delCity,
										Singleton.Spn_StateName,
										Singleton.Spn_CountryName,
										Singleton.delLandMark,
										Singleton.delpincode,
										Singleton.delLoc,
										Singleton.del_address_ID);
							}


					} else {
						Toast.makeText(getApplicationContext(), "Fill all the details", Toast.LENGTH_LONG).show();
					}

				} 
				else 
				{
					Toast.makeText(getApplicationContext(), "Connect to Internet", Toast.LENGTH_LONG).show();
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

	}

	private void insertDelAdd(final String user_id, final String delFullname,
			final String op_add, final String delCountryCode,
			final String delPh_num, final String delAddress,
			final String Spn_CityName, final String Spn_StateName,
			final String Spn_CountryName, final String delLandMark,
			final String delpincode, final String LocationName) 
	{
		RequestQueue queue = Volley.newRequestQueue(getApplicationContext()
				.getApplicationContext());
		StringRequest sr = new StringRequest(Request.Method.POST,
				ConstantUrl.Url_main + ConstantUrl.Url_insertdeliveryaddress,
				new Response.Listener<String>() {
					@Override
					public void onResponse(String response) {

						try {

							System.out.println(">>>>>>>>>>>>>");

							JSONObject json = new JSONObject(response);

							System.out.println("INSERT_Delivery_Address REsponse:  "+ response);

							String msg = json.getString("message");

							System.out.println("message >>>>>>>>>" + msg);

							if (json.getString("code").equals("200")) {

								// JSONObject data = json.getJSONObject("data");

								Toast.makeText(getApplicationContext(), "Delivery address SAVED", Toast.LENGTH_SHORT).show();

								Intent i = new Intent(DeliveryAddress_Activity.this, Edit_Add_deliverAddress.class);
								startActivity(i);
								
								finish();

							}

							else if (json.getString("code").equals("197")) {

								// JSONObject data = json.getJSONObject("data");

								Toast.makeText(
										getApplicationContext(),
										"Cannot add more than 3 address. Please select or change the previously saved address.",
										Toast.LENGTH_LONG).show();

							}

							else {
								Toast.makeText(getApplicationContext(), msg,
										Toast.LENGTH_SHORT).show();
							}

						} catch (JSONException e) {
							// TODO Auto-generated catch block
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

				JSONArray a = new JSONArray();

				params.put("userid", user_id);
				params.put("uname", delFullname);
				params.put("optionaladdress", op_add);
				params.put("contactcountrycode", delCountryCode);
				params.put("contactnumber", delPh_num);
				params.put("address", delAddress);
				params.put("district", Spn_CityName);
				params.put("state", Spn_StateName);
				params.put("country", Spn_CountryName);
				params.put("pin", delpincode);
				params.put("landmark", delLandMark);
				params.put("location", LocationName);
				

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

	private void updateDelAdd(final String user_id, final String delFullname,
			final String op_add, final String delCountryCode,
			final String delPh_num, final String delAddress,
			final String Spn_CityName, final String Spn_StateName,
			final String Spn_CountryName, final String delLandMark,
			final String delpincode, final String LocationName, final String address_id) 
	{
		RequestQueue queue = Volley.newRequestQueue(getApplicationContext()
				.getApplicationContext());
		StringRequest sr = new StringRequest(Request.Method.POST,
				ConstantUrl.Url_main + ConstantUrl.Url_updatedeliveryaddress,
				new Response.Listener<String>() {
					@Override
					public void onResponse(String response) {

						try {

							System.out.println(">>>>>>>>>>>>>");

							JSONObject json = new JSONObject(response);

							System.out.println("UPDATE_Delivery_Address REsponse:  "+ response);

							String msg = json.getString("message");

							System.out.println("message >>>>>>>>>" + msg);

							if (json.getString("code").equals("200")) {

								// JSONObject data = json.getJSONObject("data");

								Toast.makeText(getApplicationContext(), "Delivery address Updated successfully",
										Toast.LENGTH_SHORT).show();

								Intent i = new Intent(DeliveryAddress_Activity.this, Edit_Add_deliverAddress.class);
								startActivity(i);

							}

							
							else {
								Toast.makeText(getApplicationContext(), msg,
										Toast.LENGTH_SHORT).show();
							}

						} catch (JSONException e) {
							// TODO Auto-generated catch block
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

				JSONArray a = new JSONArray();

				params.put("userid", user_id);
				params.put("uname", delFullname);
				params.put("optionaladdress", op_add);
				params.put("contactcountrycode", delCountryCode);
				params.put("contactnumber", delPh_num);
				params.put("address", delAddress);
				params.put("district", Spn_CityName);
				params.put("state", Spn_StateName);
				params.put("country", Spn_CountryName);
				params.put("pin", delpincode);
				params.put("landmark", delLandMark);
				params.put("location", LocationName);
				params.put("addressid", address_id);

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

		Singleton.delCountryCode = parent.getItemAtPosition(position).toString();

	}

	@Override
	public void onNothingSelected(AdapterView<?> parent) {
		// TODO Auto-generated method stub

	}

}
