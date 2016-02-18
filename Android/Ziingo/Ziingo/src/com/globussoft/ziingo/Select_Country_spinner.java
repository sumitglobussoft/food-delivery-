/*package com.globussoft.ziingo;

import java.util.ArrayList;
import java.util.List;

import org.json.JSONArray;
import org.json.JSONObject;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.globussoft.ziingo.model.RestaurantListModel;
import com.globussoft.ziingo.utills.ConstantUrl;
import com.globussoft.ziingo.utills.Singleton;

import android.app.Activity;
import android.graphics.Color;
import android.os.Bundle;
import android.view.View;
import android.widget.AdapterView;
import android.widget.AdapterView.OnItemSelectedListener;
import android.widget.ArrayAdapter;
import android.widget.Spinner;
import android.widget.TextView;
import android.widget.Toast;

public class Select_Country_spinner extends Activity implements OnItemSelectedListener {

	private List<String> countries = new ArrayList<String>();
	// private List<String> countries = new ArrayList<String>();

	ArrayAdapter<String> dataAdapter;
	Spinner spinner;

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		// TODO Auto-generated method stub
		super.onCreate(savedInstanceState);
		setContentView(R.layout.select_country);

		spinner = (Spinner) findViewById(R.id.spinner);

		spinner.setOnItemSelectedListener(this);

		fetchCountryList();

		
	}

	@Override
	public void onItemSelected(AdapterView<?> parent, View view, int position,
			long id) {
		// TODO Auto-generated method stub
		((TextView)parent.getChildAt(0)).setText("Select Country");
		((TextView) spinner.getChildAt(0)).setTextColor(Color.BLUE);
	    ((TextView) spinner.getChildAt(0)).setTextSize(18); 
	}

	@Override
	public void onNothingSelected(AdapterView<?> parent) {
		// TODO Auto-generated method stub

	}

	public void fetchCountryList() {

		countries.clear();
		RequestQueue queue = Volley.newRequestQueue(getApplicationContext()
				.getApplicationContext());
		StringRequest sr = new StringRequest(Request.Method.GET,
				ConstantUrl.Url_main + ConstantUrl.Url_allhotels,
				new Response.Listener<String>() {
					@Override
					public void onResponse(String response) {

						try {
							JSONObject json = new JSONObject(response);

							System.out.println("country fetch response"
									+ response);

							String msg = json.getString("message");

							System.out.println("message >>>>>>>>>" + msg);

							if (json.getString("code").equals("200")) {

								JSONArray jsonMainArr = json
										.getJSONArray("data");

								for (int j = 0; j < jsonMainArr.length(); j++) {								

									JSONObject childJSONObject = jsonMainArr
											.getJSONObject(j);									

									countries.add(childJSONObject
											.getString("country"));

								}	
								
								System.out.println("Countries >> "+ countries);
								
								// Creating adapter for spinner
								dataAdapter = new ArrayAdapter<String>(getApplicationContext(), android.R.layout.simple_spinner_item, countries);
								// Drop down layout style - list view with radio button
								dataAdapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
								// attaching data adapter to spinner
								spinner.setAdapter(dataAdapter);	
								
							}

							else {

								Toast.makeText(
										Select_Country_spinner.this
												.getApplicationContext(), msg,
										Toast.LENGTH_LONG).show();
							}

						} catch (Exception e) 
						
						{
							e.printStackTrace();
						}						
						
											
						//dataAdapter.notifyDataSetChanged();

					}

				}, new Response.ErrorListener() {
					@Override
					public void onErrorResponse(VolleyError error) {

						System.out.println("Error : " + error);

					}
				});

		queue.add(sr);

	}

}
*/