package com.globussoft.ziingo.fragment;

import java.util.HashMap;
import java.util.Map;

import okhttp3.internal.DiskLruCache.Snapshot;

import org.json.JSONArray;
import org.json.JSONObject;

import android.content.Intent;
import android.content.SharedPreferences;
import android.content.SharedPreferences.Editor;
import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.view.LayoutInflater;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.ViewGroup;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.Toast;

import com.android.volley.AuthFailureError;
import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.globussoft.ziingo.Choose_spinner_country;
import com.globussoft.ziingo.MainActivity;
import com.globussoft.ziingo.R;
import com.globussoft.ziingo.UserProfile;
import com.globussoft.ziingo.model.RestaurantListModel;
import com.globussoft.ziingo.utills.ConnectionDetector;
import com.globussoft.ziingo.utills.ConstantUrl;
import com.globussoft.ziingo.utills.Singleton;

public class AccountFragment extends Fragment {
	
	 EditText firstName, lastName, phone, city, state, country ;
	 
	 ImageView  save, ed_fn, ed_ln, ed_ph, ed_city, ed_state, ed_country;
	 View rootView ;
	 
	 SharedPreferences pref;
	 Editor editor;
	 int PRIVATE_MODE = 0;
	
	 @Override
	    public View onCreateView(LayoutInflater inflater, ViewGroup container,
	            Bundle savedInstanceState) {
	  
	       rootView = inflater.inflate(R.layout.fragment_account, container, false);
	        
	        Initui();
	          
	        return rootView;
	    }
	 
	 protected void sharedPrefernces() {
			
			pref = getActivity().getSharedPreferences("Ziingo", PRIVATE_MODE);
			editor = pref.edit();
		    editor.putString("firstName", Singleton.firstName);
			editor.putString("lastName", Singleton.lastName);
			editor.putString("city", Singleton.cityName);
			editor.putString("state", Singleton.stateName);
			editor.putString("country", Singleton.countryName);
			editor.putString("phone", Singleton.phone);
			editor.commit();

		}

	 
	 private void Initui() {
		 
		 firstName = (EditText) rootView.findViewById(R.id.accfirstname);
		 lastName = (EditText) rootView.findViewById(R.id.acc_lastname);
		 phone = (EditText) rootView.findViewById(R.id.accph_num1);
		 city = (EditText) rootView.findViewById(R.id.acc_city);
		 state = (EditText) rootView.findViewById(R.id.acc_state);
		 country = (EditText) rootView.findViewById(R.id.acc_country);
		 //bck_btn = (ImageView) rootView.findViewById(R.id.up_bkbtn);
		 
		 ed_fn = (ImageView) rootView.findViewById(R.id.accfirstname_edit);
		 ed_ln = (ImageView) rootView.findViewById(R.id.acc_lastname_edit);
		 ed_ph = (ImageView) rootView.findViewById(R.id.accph_num_edit);
		 ed_city = (ImageView) rootView.findViewById(R.id.acc_city_edit);
		 ed_state = (ImageView) rootView.findViewById(R.id.acc_state_edit);
		 ed_country = (ImageView) rootView.findViewById(R.id.acc_country_edit);
		 
		 Singleton.previousfragment = "Profile";
		 Singleton.currentfragment = "FoodsFragment";
		 
		 save = (ImageView) rootView.findViewById(R.id.acc_save);
		 
		 ed_fn.setOnClickListener(new OnClickListener() {
			
			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub
				
				firstName.setText(null);
				
			}
		});
		 ed_ln.setOnClickListener(new OnClickListener() {
				
				@Override
				public void onClick(View v) {
					// TODO Auto-generated method stub
					
					lastName.setText(null);
					
				}
			});
		 ed_city.setOnClickListener(new OnClickListener() {
				
				@Override
				public void onClick(View v) {
					// TODO Auto-generated method stub
					
					city.setText(null);
					
				}
			});
		 ed_ph.setOnClickListener(new OnClickListener() {
				
				@Override
				public void onClick(View v) {
					// TODO Auto-generated method stub
					
					phone.setText(null);
					
				}
			});
		 ed_state.setOnClickListener(new OnClickListener() {
			
			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub
				
				state.setText(null);
				
			}
		});
		 ed_country.setOnClickListener(new OnClickListener() {
				
				@Override
				public void onClick(View v) {
					// TODO Auto-generated method stub
					
					country.setText(null);
					
				}
			});
		 
		 save.setOnClickListener(new OnClickListener() {

				@Override
				public void onClick(View v) {

					if (new ConnectionDetector(getActivity()).isConnectingToInternet()) {
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
						 
						// Singleton.userAtCart = true;

							userData(Singleton.user_id, Singleton.firstName, Singleton.lastName,
									 Singleton.phone, Singleton.user_city,
									Singleton.user_state, Singleton.user_country);	

						} 
						else 
						{
							Toast.makeText(getActivity(), "Fill all the details", Toast.LENGTH_LONG).show();
						}

					} 
					else 
					{
						Toast.makeText(getActivity(),"Connect to Internet", Toast.LENGTH_LONG).show();
					}

				}

			});
		 
		 fetchProfile(Singleton.user_id);		 
		 
	 }
	 
	 private void fetchProfile(final String userid ) 
	 {
			
			RequestQueue queue = Volley.newRequestQueue(getActivity().getApplicationContext());
			StringRequest sr = new StringRequest(Request.Method.POST,ConstantUrl.Url_main + ConstantUrl.Url_getuserprofileinfo,
					new Response.Listener<String>() {
						@Override
						public void onResponse(String response) {

							try {
								JSONObject json = new JSONObject(response);

								System.out.println("fetchUserProfile_response"+ response);

								String msg = json.getString("message");

								System.out.println("message >>>>>>>>>" + msg);

								if (json.getString("code").equals("200")) {

									JSONObject jobj = json.getJSONObject("data");

									
										firstName.setText(jobj.getString("first_name"));
										lastName.setText(jobj.getString("last_name"));
										phone.setText(jobj.getString("phone"));
										city.setText(jobj.getString("city"));
										state.setText(jobj.getString("state"));
										country.setText(jobj.getString("country"));
									//	address.setText.(jobj.getString("address"));
										
										Singleton.user_name = jobj.getString("first_name");

									
								}

								else {

									Toast.makeText(getActivity(),msg, Toast.LENGTH_LONG).show();
								}

							} catch (Exception e) 
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
					params.put("userid", userid);

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
	 
	 private void userData(final String user_id, final String firstName,
				final String lastName,  final String phone,
				final String city, final String state, final String country) {
		
			RequestQueue queue = Volley.newRequestQueue(getActivity());
			
			System.out.println("*************");
			
			StringRequest sr = new StringRequest(Request.Method.POST,
					ConstantUrl.Url_main + ConstantUrl.Url_userprofileinfo,
					new Response.Listener<String>() {
						
						@Override
						public void onResponse(String response) {
							
							System.out.println("@@@@@@@@@@@@@@@@@@@@@@@@@");

							System.out.println("ACC_UserProfile response" + response);

							try {
								JSONObject json = new JSONObject(response);

								String msg = json.getString("message");

								if (json.getString("code").equals("200")) {

									//JSONObject obj = json.getJSONObject("data");

									System.out.println("message >>>>>>>>>" + msg);

									Toast.makeText(getActivity(), "Profile saved", Toast.LENGTH_LONG).show();

									System.out.println("Successfully SAVED ");
									
									sharedPrefernces();	
									
//									MainActivity.mManager = getActivity().getSupportFragmentManager();
//									MainActivity.swipeFragment(new FoodsFragment());

								}

								else 
								{
									Toast.makeText(getActivity(), msg, Toast.LENGTH_LONG).show();
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

					System.out.println("user_id = "+ user_id);
					System.out.println("firstName = "+ firstName);
					System.out.println("lastName = "+ lastName);
					//System.out.println("address = "+ address);
					System.out.println("phone = "+ phone);
					System.out.println("city = "+ city);
					System.out.println("state = "+ state);
					System.out.println("country = "+ country);
					
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
