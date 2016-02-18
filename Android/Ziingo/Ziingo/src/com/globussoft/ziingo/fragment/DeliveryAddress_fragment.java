/*package com.globussoft.ziingo.fragment;

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
import com.globussoft.ziingo.R;
import com.globussoft.ziingo.utills.ConnectionDetector;
import com.globussoft.ziingo.utills.ConstantUrl;
import com.globussoft.ziingo.utills.Singleton;

import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.view.LayoutInflater;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.ViewGroup;
import android.webkit.WebView.FindListener;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.TextView;
import android.widget.Toast;

public class DeliveryAddress_fragment extends Fragment {

	View rootView;
	EditText del_fn, del_ph, del_add, del_lndmrk, del_city, del_state;
	ImageView del_fn_ed, del_ph_ed, del_add_ed, del_lndmrk_ed, del_city_ed, del_state_ed, del_save_btn;

	@Override
	public View onCreateView(LayoutInflater inflater, ViewGroup container,
			Bundle savedInstanceState) {

		rootView = inflater
				.inflate(R.layout.fragment_del_add, container, false);
		System.out.println(" Food Fragment ");
		InitDelUI();
		return rootView;
	}

	public void InitDelUI() {

		del_fn = (EditText) rootView.findViewById(R.id.del_firstname);
		del_ph = (EditText) rootView.findViewById(R.id.ph_num);
		del_add = (EditText) rootView.findViewById(R.id.del_address);
		del_lndmrk = (EditText) rootView.findViewById(R.id.del_landmark);
		del_city = (EditText) rootView.findViewById(R.id.delcity);
		del_state = (EditText) rootView.findViewById(R.id.delstate);
		
		del_fn_ed = (ImageView) rootView.findViewById(R.id.del_fn_edit);
		del_ph_ed = (ImageView) rootView.findViewById(R.id.del_ph_edit);
		del_add_ed = (ImageView) rootView.findViewById(R.id.del_add_edit);
		del_lndmrk_ed = (ImageView) rootView.findViewById(R.id.del_lndmrk_edit);
		del_city_ed = (ImageView) rootView.findViewById(R.id.del_city_edit);
		del_state_ed = (ImageView) rootView.findViewById(R.id.del_state_edit);		
		del_save_btn = (ImageView) rootView.findViewById(R.id.del_save);

		del_save_btn.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub

				if (new ConnectionDetector(getActivity())
						.isConnectingToInternet()) {
					if (del_fn.getText().toString().length() !=0
							&& del_ph.getText().toString().length() !=0
							&& del_lndmrk.getText().toString().length() !=0
							&& del_add.getText().toString().length() !=0
							&& del_city.getText().toString().length() !=0
							&& del_state.getText().toString().length() !=0)

					{
						
						if (Singleton.firstName != null) {
							del_fn.setText(Singleton.firstName);
							Singleton.delFirstname = Singleton.firstName;
							System.out
									.println("Singleton.delFirstname = Singleton.firstName = "
											+ Singleton.delFirstname);
						} else {
							Singleton.delFirstname = del_fn.getText()
									.toString();

						}

						if (Singleton.phone != null) {
							del_ph.setText(Singleton.phone);
							Singleton.delPh_num = Singleton.phone;
							System.out
									.println("Singleton.delPh_num = Singleton.phone = "
											+ Singleton.delPh_num);
						} else {
							Singleton.delPh_num = del_ph.getText().toString();

						}

						if (Singleton.user_address != null) {
							del_add.setText(Singleton.user_address);
							Singleton.delAddress = Singleton.user_address;
							System.out
									.println("Singleton.delAddress = Singleton.user_address = "
											+ Singleton.delAddress);
						} else {
							
							Singleton.delAddress = del_add.getText().toString();

						}
						
						Singleton.delLandMark = del_lndmrk.getText().toString();
						
						if (Singleton.cityName != null) {
							del_city.setText(Singleton.cityName);
							Singleton.delCity = Singleton.cityName;
							System.out
									.println("Singleton.delCity = Singleton.cityName = "
											+ Singleton.delCity);
						} else {
							
							Singleton.delCity = del_city.getText().toString();

						}
						
						if (Singleton.stateName != null) {
							del_state.setText(Singleton.stateName);
							Singleton.delState = Singleton.stateName;
							System.out
									.println("Singleton.delState = Singleton.stateName = "
											+ Singleton.delState);
						} else {
							
							Singleton.delState = del_state.getText().toString();

						}
						
						insertDelAdd(Singleton.user_id, Singleton.delFirstname, Singleton.delPh_num, Singleton.delAddress, 
									 Singleton.cityName, Singleton.stateName, Singleton.countryName, Singleton.delLandMark,
									 Singleton.product_cartid);

					} else {
						Toast.makeText(getActivity(), "Fill all the details",
								Toast.LENGTH_LONG).show();
					}

				} else {
					Toast.makeText(getActivity(), "Connect to Internet",
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
		
		del_city_ed.setOnClickListener(new OnClickListener() {

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
		});
		
		

	}
	 
	public void insertDelAdd(final String user_id, final String delFirstname, final String delPh_num, final String delAddress, 
			final String cityName, final String stateName, final String countryName, final String delLandMark,
			 final List<String> product_cartid ){
		
		System.out.println("user_id = "+ user_id);
		System.out.println("delFirstname = "+ delFirstname);
		System.out.println("delPh_num = "+ delPh_num);
		System.out.println("delAddress = "+ delAddress);
		System.out.println("cityName = "+ cityName);
		System.out.println("stateName = "+ stateName);
		System.out.println("countryName = "+ countryName);
		System.out.println("delLandMark = "+ delLandMark);
		//System.out.println("del_time = "+ del_time);
		System.out.println("cart_id = "+ product_cartid);
		


		RequestQueue queue = Volley.newRequestQueue(getActivity().getApplicationContext());
		StringRequest sr = new StringRequest(Request.Method.POST,
				ConstantUrl.Url_main + ConstantUrl.Url_insertdeliveryaddress,
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

								String data = json.getString("data");
								
											
								
								Toast.makeText(
										getActivity().getApplicationContext(),
										"Delivery address SAVED",
										Toast.LENGTH_SHORT).show();							
								
							}

							else {

								Toast.makeText(getActivity().getApplicationContext(),
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
				
				Map<String, List<String>> listParams = new HashMap<String, List<String>>();
				listParams.put("cart_id", product_cartid);
				
				Map<String, String> params = new HashMap<String, String>();
				
				JSONArray a=new JSONArray();
				
				for (int i = 0; i < product_cartid.size(); i++) {
					
					a.put(product_cartid.get(i));
				}
				
				params.put("cart_id", a.toString());				
				params.put("userid", user_id);
				params.put("fullname", delFirstname);
				params.put("address", delAddress);
				params.put("phnum", delPh_num);
				params.put("city", cityName);
				params.put("state", stateName);
				params.put("country", countryName);
				params.put("landmark", delLandMark);

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
*/