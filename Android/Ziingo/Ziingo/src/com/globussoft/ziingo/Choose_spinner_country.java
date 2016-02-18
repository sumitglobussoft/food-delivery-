package com.globussoft.ziingo;

import java.util.ArrayList;
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
import com.globussoft.ziingo.adapter.ChooseCountryAdapter;
import com.globussoft.ziingo.adapter.ChooseSpinnerCityAdapter;
import com.globussoft.ziingo.adapter.ChooseSpinnerCountryAdapter;
import com.globussoft.ziingo.adapter.ChooseSpinnerLocAdapter;
import com.globussoft.ziingo.adapter.ChooseSpinnerStateAdapter;
import com.globussoft.ziingo.adapter.RestaurantListAdapter;
import com.globussoft.ziingo.model.BuyProductModel;
import com.globussoft.ziingo.model.ChooseCountryModel;
import com.globussoft.ziingo.model.ChooseSpinnerCityModel;
import com.globussoft.ziingo.model.ChooseSpinnerCountryModel;
import com.globussoft.ziingo.model.ChooseSpinnerLocationModel;
import com.globussoft.ziingo.model.ChooseSpinnerStateModel;
import com.globussoft.ziingo.model.RestaurantListModel;
import com.globussoft.ziingo.ui.AppLocationService;
import com.globussoft.ziingo.ui.LocationAddress;
import com.globussoft.ziingo.utills.ConstantUrl;
import com.globussoft.ziingo.utills.Singleton;

import android.app.Activity;
import android.app.Dialog;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.SharedPreferences;
import android.content.SharedPreferences.Editor;
import android.location.Criteria;
import android.location.Location;
import android.location.LocationListener;
import android.location.LocationManager;
import android.os.Bundle;
import android.os.Handler;
import android.os.Message;
import android.provider.Settings;
import android.support.v7.app.AlertDialog;
import android.util.Log;
import android.view.View;
import android.view.ViewGroup;
import android.view.View.OnClickListener;
import android.widget.AdapterView;
import android.widget.AdapterView.OnItemClickListener;
import android.widget.AdapterView.OnItemSelectedListener;
import android.widget.ArrayAdapter;
import android.widget.ProgressBar;
import android.widget.RelativeLayout;
import android.widget.Spinner;
import android.widget.TextView;
import android.widget.Toast;

public class Choose_spinner_country extends Activity implements
		OnItemSelectedListener, LocationListener {

	private List<ChooseSpinnerCountryModel> spnrCntryList = new ArrayList<ChooseSpinnerCountryModel>();
	private ChooseSpinnerCountryAdapter countryadapter;

	private List<ChooseSpinnerStateModel> spnrStateList = new ArrayList<ChooseSpinnerStateModel>();
	private ChooseSpinnerStateAdapter stateadapter;

	private List<ChooseSpinnerCityModel> spnrCityList = new ArrayList<ChooseSpinnerCityModel>();
	private ChooseSpinnerCityAdapter cityadapter;

	private List<ChooseSpinnerLocationModel> spnrLocList = new ArrayList<ChooseSpinnerLocationModel>();
	private ChooseSpinnerLocAdapter locadapter;

	Spinner spinner_country, spinner_state, spinner_city, spinner_loc;
	RelativeLayout use_my_loc;
	TextView show_rest;
	ProgressBar loc_pro;
	
	private double longitude, latitude;
	private String provider;
	private Location location;
	private AppLocationService appLocationService;
	public LocationManager locationManager;

	// The minimum distance to change Updates in meters
	private static final long MIN_DISTANCE_CHANGE_FOR_UPDATES = 10; // 10 meters
	// The minimum time between updates in milliseconds
	private static final long MIN_TIME_BW_UPDATES = 1000 * 60 * 1; // 1 minute
	
	// Shared Preferences
		public static SharedPreferences pref;

		// Editor for Shared preferences
		Editor editor;

		// Shared pref mode
		int PRIVATE_MODE = 0;

	@Override
	protected void onCreate(Bundle savedInstanceState) 
	{
		// TODO Auto-generated method stub
		super.onCreate(savedInstanceState);
		setContentView(R.layout.choose_location);

		Initui();
	}
	
protected void sharedPrefernces() {
		
		pref = getSharedPreferences("Location_Credentials", MODE_PRIVATE);	
		
		editor = pref.edit();
	    editor.putString("CountryName", Singleton.Spn_CountryName);
		editor.putString("StateName", Singleton.Spn_StateName);
		editor.putString("CityName", Singleton.Spn_CityName);
		editor.putString("LocationName", Singleton.Spn_LocationName);
		editor.putBoolean("Spinner_loc", true);
		editor.commit();
		
		/*Singleton.Spn_CountryName=pref.getString("CountryName", Singleton.Spn_CountryName);
		Singleton.Spn_StateName=pref.getString("StateName", Singleton.Spn_StateName);
		Singleton.Spn_CityName=pref.getString("CityName", Singleton.Spn_CityName);
		Singleton.Spn_LocationName=pref.getString("LocationName", Singleton.Spn_LocationName);*/
		Singleton.Spn_loc_saved= pref.getBoolean("Spinner_loc", true);
		
	}

	private void Initui() 
	{
		use_my_loc = (RelativeLayout) findViewById(R.id.rel_usemyloc);
		show_rest = (TextView) findViewById(R.id.shw_rtr);
		loc_pro = (ProgressBar) findViewById(R.id.loc_pro);
		
		// Spinner element
		spinner_country = (Spinner) findViewById(R.id.spinner_country);
		spinner_state = (Spinner) findViewById(R.id.spinner_state);
		spinner_city = (Spinner) findViewById(R.id.spinner_city);
		spinner_loc = (Spinner) findViewById(R.id.spinner_location);
		
		use_my_loc.setOnClickListener(new OnClickListener() {
			
			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub
				
				//System.out.println("Singleton.cityName" +Singleton.cityName);
				
				// Get Current Location of User
				appLocationService = new AppLocationService(Choose_spinner_country.this);
				locationManager = (LocationManager) getSystemService(Context.LOCATION_SERVICE);

				Criteria criteria = new Criteria();
				provider = locationManager.getBestProvider(criteria, false);
				Location location = locationManager.getLastKnownLocation(provider);
				
				if (location != null) 
				{					
					loc_pro.setVisibility(View.INVISIBLE);					
					System.out.println("location not null");
					onLocationChanged(location);
				} 
				else 
				{
					loc_pro.setVisibility(View.VISIBLE);
					System.out.println(" location = null");
					StartGps();
					
									
				}
				
			}
		});
		
		show_rest.setOnClickListener(new OnClickListener() {
			
			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub	
				
				
				if(Singleton.Spn_CountryName != null 
						&& Singleton.Spn_StateName != null
						&& Singleton.Spn_CityName != null 
						&& Singleton.Spn_LocationName != null)
				{
					sharedPrefernces() ;
					
				Intent i = new Intent(Choose_spinner_country.this, MainActivity.class);
				startActivity(i);
				}
				else
				{
					Toast.makeText(getApplicationContext(), "Please choose location", Toast.LENGTH_SHORT).show();
				}
			}
		});
		

		// Spinner click listener
		// spinner_country.setOnItemSelectedListener(this);
		//spinner_state.setOnItemSelectedListener(this);
		//spinner_city.setOnItemSelectedListener(this);
		//spinner_loc.setOnItemSelectedListener(this);

		countryadapter = new ChooseSpinnerCountryAdapter(this,android.R.layout.simple_spinner_item, spnrCntryList);
		countryadapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
		spinner_country.setAdapter(countryadapter);
		

		stateadapter = new ChooseSpinnerStateAdapter(this,android.R.layout.simple_spinner_item, spnrStateList);
		stateadapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
		spinner_state.setAdapter(stateadapter);

		cityadapter = new ChooseSpinnerCityAdapter(this,android.R.layout.simple_spinner_item, spnrCityList);
		cityadapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
		spinner_city.setAdapter(cityadapter);

		locadapter = new ChooseSpinnerLocAdapter(this,android.R.layout.simple_spinner_item, spnrLocList);
		locadapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
		spinner_loc.setAdapter(locadapter);		
		
		fetchSpinnerCountrylist();
		
		spinner_country.setOnItemSelectedListener(new OnItemSelectedListener() 
		{

			@Override
			public void onItemSelected(AdapterView<?> parent, View view,int position, long id)
			{
				// TODO Auto-generated method stub
				

				System.out.println("clicking on country");
				Singleton.Spn_CountryID = spnrCntryList.get(position).getSpinner_locationId();
				Singleton.Spn_CountryName = spnrCntryList.get(position).getSpinner_Country();
				
				System.out.println("Selected COUNTRY : "+ Singleton.Spn_CountryName);

				fetchSpinnerStatelist(Singleton.Spn_CountryID);

			}

			@Override
			public void onNothingSelected(AdapterView<?> parent) 
			{
				
			}

		});
		
		
		
		spinner_state.setOnItemSelectedListener(new OnItemSelectedListener() {

			@Override
			public void onItemSelected(AdapterView<?> parent, View view,
					int position, long id) {
				System.out.println("clicking on spinner_state");
				// TODO Auto-generated method stub

				Singleton.Spn_StateID = spnrStateList.get(position).getSpinner_State_id();
				Singleton.Spn_StateName = spnrStateList.get(position).getSpinner_State();
				System.out.println("Selected STATE : " + Singleton.Spn_StateName);
				
				fetchSpinnerCitylist(Singleton.Spn_StateID);

			}

			@Override
			public void onNothingSelected(AdapterView<?> parent) {
				// TODO Auto-generated method stub

			}

		});
		
		
		spinner_city.setOnItemSelectedListener(new OnItemSelectedListener() {

			@Override
			public void onItemSelected(AdapterView<?> parent, View view,
					int position, long id) {
				// TODO Auto-generated method stub
				System.out.println("clicking on spinner_city");
				Singleton.Spn_CityID = spnrCityList.get(position).getSpinner_City_id();
				Singleton.Spn_CityName = spnrCityList.get(position).getSpinner_City();
				System.out.println("Selected CITY : " + Singleton.Spn_CityName);

				fetchSpinnerLocationlist(Singleton.Spn_CityID);

			}

			@Override
			public void onNothingSelected(AdapterView<?> parent) {
				// TODO Auto-generated method stub

			}

		});
		
		
		spinner_loc.setOnItemSelectedListener(new OnItemSelectedListener() {

			@Override
			public void onItemSelected(AdapterView<?> parent, View view,
					int position, long id) {
				// TODO Auto-generated method stub
				System.out.println("clicking on spinner_loc");
				Singleton.Spn_LocationID = spnrLocList.get(position).getSpinner_Loc_id();
				Singleton.Spn_LocationName = spnrLocList.get(position).getSpinner_Loc();
				System.out.println("Selected LOC : " + Singleton.Spn_LocationName);

			

			}

			@Override
			public void onNothingSelected(AdapterView<?> parent) {
				// TODO Auto-generated method stub

			}

		});

	}
	
	

	@Override
	protected void onResume() {
		super.onResume();
		if(Singleton.cityName == null || Singleton.cityName.length() <= 0){
			getLocation();	
		}
		
	}
	
	
	private Location getLocation() {		
		
		
		try {
			boolean canGetLocation;
			LocationManager locationManager = (LocationManager) getSystemService(LOCATION_SERVICE);

			// getting GPS status
			boolean isGPSEnabled = locationManager.isProviderEnabled(LocationManager.GPS_PROVIDER);

			// getting network status
			boolean isNetworkEnabled = locationManager.isProviderEnabled(LocationManager.NETWORK_PROVIDER);

			if (!isGPSEnabled && !isNetworkEnabled) {
				// no network provider is enabled
			} else {
				canGetLocation = true;
				// First get location from Network Provider
				if (isNetworkEnabled) {
					locationManager.requestLocationUpdates(
							LocationManager.NETWORK_PROVIDER,
							MIN_TIME_BW_UPDATES,
							MIN_DISTANCE_CHANGE_FOR_UPDATES, this);
					Log.d("Network", "Network");
					if (locationManager != null) {
						location = locationManager
								.getLastKnownLocation(LocationManager.NETWORK_PROVIDER);
						if (location != null) {
							latitude = location.getLatitude();
							longitude = location.getLongitude();
						}
					}
				}
				// if GPS Enabled get lat/long using GPS Services
				if (isGPSEnabled) {
					if (location == null) {
						locationManager.requestLocationUpdates(
								LocationManager.GPS_PROVIDER,
								MIN_TIME_BW_UPDATES,
								MIN_DISTANCE_CHANGE_FOR_UPDATES, this);
						Log.d("GPS Enabled", "GPS Enabled");
						if (locationManager != null) {
							location = locationManager
									.getLastKnownLocation(LocationManager.GPS_PROVIDER);
							if (location != null) {
								latitude = location.getLatitude();
								longitude = location.getLongitude();
							}
						}
					}
				}
			}

		} catch (Exception e) {
			e.printStackTrace();
		}

		return location;
	}

	protected boolean StartGps() {
		// TODO Auto-generated method stub
		
		
			  // Get Location Manager and check for GPS & Network location services
			  LocationManager lm = (LocationManager) getSystemService(LOCATION_SERVICE);
			  if (!lm.isProviderEnabled(LocationManager.GPS_PROVIDER)
			    || !lm.isProviderEnabled(LocationManager.NETWORK_PROVIDER)) {
				

				  
					AlertDialog.Builder alertDialog2 = new AlertDialog.Builder(
						    Choose_spinner_country.this);
						
						alertDialog2.setTitle("Location Services Not Active");
						
						alertDialog2.setMessage("Please enable Location Services and GPS");

									

						// Setting Positive "Yes" Btn
						alertDialog2.setPositiveButton("OK",
						    new DialogInterface.OnClickListener() {
						        public void onClick(DialogInterface dialog, int which) {
						            // Write your code here to execute after dialog
						        	
						        	startActivityForResult(new Intent(Settings.ACTION_LOCATION_SOURCE_SETTINGS), 2);
						          
						        }
						    });

						// Setting Negative "NO" Btn
						/*alertDialog2.setNegativeButton("NO",
						    new DialogInterface.OnClickListener() {
						        public void onClick(DialogInterface dialog, int which) {
						            // Write your code here to execute after dialog
						            
						            dialog.cancel();
						        }
						    });*/

						// Showing Alert Dialog					
						  Dialog alertDialog = alertDialog2.create();
						  alertDialog.setCanceledOnTouchOutside(false);
						alertDialog2.show();
		
				  
				  
			  }
			return lm.isProviderEnabled(LocationManager.GPS_PROVIDER)
			    && lm.isProviderEnabled(LocationManager.NETWORK_PROVIDER);
		}
		
	

	/*@Override
	public void onItemSelected(AdapterView<?> parent, View view, int position,
			long id) {
		// TODO Auto-generated method stub

		// On selecting a spinner item
		// String item = parent.getItemAtPosition(position).toString();

		// Showing selected spinner item
		
		 * Toast.makeText(parent.getContext(), "Selected: " +
		 * Singleton.Spn_CountryName, Toast.LENGTH_LONG) .show();
		 

		switch (parent.getId()) {
		case R.id.spinner_country:

			Singleton.Spn_CountryID = spnrCntryList.get(position)
					.getSpinner_locationId();
			Singleton.Spn_CountryName = spnrCntryList.get(position)
					.getSpinner_Country();
			System.out.println("Selected COUNTRY : "
					+ Singleton.Spn_CountryName);

			fetchSpinnerStatelist(Singleton.Spn_CountryID);

			break;
		case R.id.spinner_state:

			Singleton.Spn_StateID = spnrStateList.get(position)
					.getSpinner_State_id();
			Singleton.Spn_StateName = spnrStateList.get(position)
					.getSpinner_State();
			System.out.println("Selected STATE : " + Singleton.Spn_StateName);

			fetchSpinnerCitylist(Singleton.Spn_StateID);

			break;

		case R.id.spinner_city:

			Singleton.Spn_CityID = spnrCityList.get(position)
					.getSpinner_City_id();
			Singleton.Spn_CityName = spnrCityList.get(position)
					.getSpinner_City();
			System.out.println("Selected CITY : " + Singleton.Spn_CityName);

			fetchSpinnerLocationlist(Singleton.Spn_CityID);

			break;

		case R.id.spinner_location:

			Singleton.Spn_LocationID = spnrLocList.get(position)
					.getSpinner_Loc_id();
			Singleton.Spn_LocationName = spnrLocList.get(position)
					.getSpinner_Loc();
			System.out.println("Selected LOC : " + Singleton.Spn_LocationName);

			fetchSpinnerLocationlist(Singleton.Spn_LocationID);

			break;
		default:
			break;
		}

	}
*/
	@Override
	public void onNothingSelected(AdapterView<?> parent) {
		// TODO Auto-generated method stub

	}

	public void fetchSpinnerCountrylist() {

		spnrCntryList.clear();

		RequestQueue queue = Volley.newRequestQueue(this
				.getApplicationContext());
		StringRequest sr = new StringRequest(Request.Method.GET,
				ConstantUrl.Url_main + ConstantUrl.Url_getcountrys,
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

									ChooseSpinnerCountryModel cntryLstModel = new ChooseSpinnerCountryModel();

									JSONObject childJSONObject = jsonMainArr
											.getJSONObject(j);

									cntryLstModel
											.setSpinner_Country(childJSONObject
													.getString("name"));
									cntryLstModel
											.setSpinner_locationId(childJSONObject
													.getString("location_id"));

									spnrCntryList.add(cntryLstModel);

								}
							} else {

								Toast.makeText(
										Choose_spinner_country.this
												.getApplicationContext(), msg,
										Toast.LENGTH_LONG).show();
							}

						} catch (Exception e)

						{
							e.printStackTrace();
						}

						countryadapter.notifyDataSetChanged();

					}

				}, new Response.ErrorListener() {
					@Override
					public void onErrorResponse(VolleyError error) {

						System.out.println("Error : " + error);

					}
				});

		queue.add(sr);

	}

	public void fetchSpinnerStatelist(final String Spn_CountryID) 
	{

		spnrStateList.clear();

		RequestQueue queue = Volley.newRequestQueue(this
				.getApplicationContext());
		StringRequest sr = new StringRequest(Request.Method.POST,
				ConstantUrl.Url_main + ConstantUrl.Url_getStatesByCountrys,
				new Response.Listener<String>() 
				{
					@Override
					public void onResponse(String response) 
					{

						try 
						{
							JSONObject json = new JSONObject(response);

							System.out.println("State fetch response"
									+ response);

							String msg = json.getString("message");

							System.out.println("message >>>>>>>>>" + msg);

							if (json.getString("code").equals("200")) 
							{

								JSONArray jsonMainArr = json
										.getJSONArray("data");

								for (int j = 0; j < jsonMainArr.length(); j++) 
								{

									ChooseSpinnerStateModel cntryLstModel = new ChooseSpinnerStateModel();

									JSONObject childJSONObject = jsonMainArr
											.getJSONObject(j);

									cntryLstModel
											.setSpinner_State(childJSONObject
													.getString("name"));
									cntryLstModel
											.setSpinner_State_id(childJSONObject
													.getString("location_id"));

									spnrStateList.add(cntryLstModel);

								}
							} else {

								Toast.makeText(
										Choose_spinner_country.this
												.getApplicationContext(), msg,
										Toast.LENGTH_LONG).show();
							}

						} catch (Exception e)

						{
							e.printStackTrace();
						}

						stateadapter.notifyDataSetChanged();

					}

				}, new Response.ErrorListener() {
					@Override
					public void onErrorResponse(VolleyError error) {

						System.out.println("Error : " + error);

					}
				})

		{
			@Override
			protected Map<String, String> getParams() {
				Map<String, String> params = new HashMap<String, String>();
				params.put("country_id", Spn_CountryID);

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

	public void fetchSpinnerCitylist(final String Spn_StateID) {

		spnrCityList.clear();

		RequestQueue queue = Volley.newRequestQueue(this
				.getApplicationContext());
		StringRequest sr = new StringRequest(Request.Method.POST,
				ConstantUrl.Url_main + ConstantUrl.Url_getcitysbystates,
				new Response.Listener<String>() {
					@Override
					public void onResponse(String response) {

						try {
							JSONObject json = new JSONObject(response);

							System.out.println("State fetch response"
									+ response);

							String msg = json.getString("message");

							System.out.println("message >>>>>>>>>" + msg);

							if (json.getString("code").equals("200")) {

								JSONArray jsonMainArr = json
										.getJSONArray("data");

								for (int j = 0; j < jsonMainArr.length(); j++) {

									ChooseSpinnerCityModel cntryLstModel = new ChooseSpinnerCityModel();

									JSONObject childJSONObject = jsonMainArr
											.getJSONObject(j);

									cntryLstModel
											.setSpinner_City(childJSONObject
													.getString("name"));
									cntryLstModel
											.setSpinner_City_id(childJSONObject
													.getString("location_id"));

									spnrCityList.add(cntryLstModel);

								}
							} else {

								Toast.makeText(
										Choose_spinner_country.this
												.getApplicationContext(), msg,
										Toast.LENGTH_LONG).show();
							}

						} catch (Exception e)

						{
							e.printStackTrace();
						}

						cityadapter.notifyDataSetChanged();

					}

				}, new Response.ErrorListener() {
					@Override
					public void onErrorResponse(VolleyError error) {

						System.out.println("Error : " + error);

					}
				})

		{
			@Override
			protected Map<String, String> getParams() {
				Map<String, String> params = new HashMap<String, String>();
				params.put("state_id", Spn_StateID);

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

	public void fetchSpinnerLocationlist(final String Spn_CityID) {

		spnrLocList.clear();

		RequestQueue queue = Volley.newRequestQueue(this
				.getApplicationContext());
		StringRequest sr = new StringRequest(Request.Method.POST,
				ConstantUrl.Url_main + ConstantUrl.Url_getlocations,
				new Response.Listener<String>() {
					@Override
					public void onResponse(String response) {

						try {
							JSONObject json = new JSONObject(response);

							System.out.println("location fetch response"
									+ response);

							String msg = json.getString("message");

							System.out.println("message >>>>>>>>>" + msg);

							if (json.getString("code").equals("200")) {

								JSONArray jsonMainArr = json
										.getJSONArray("data");

								for (int j = 0; j < jsonMainArr.length(); j++) {

									ChooseSpinnerLocationModel locLstModel = new ChooseSpinnerLocationModel();

									JSONObject childJSONObject = jsonMainArr
											.getJSONObject(j);

									locLstModel
											.setSpinner_Loc(childJSONObject
													.getString("name"));
									locLstModel
											.setSpinner_Loc_id(childJSONObject
													.getString("location_id"));

									spnrLocList.add(locLstModel);

								}
							} else {

								Toast.makeText(
										Choose_spinner_country.this
												.getApplicationContext(), msg,
										Toast.LENGTH_LONG).show();
							}

						} catch (Exception e)

						{
							e.printStackTrace();
						}

						locadapter.notifyDataSetChanged();

					}

				}, new Response.ErrorListener() {
					@Override
					public void onErrorResponse(VolleyError error) {

						System.out.println("Error : " + error);

					}
				})

		{
			@Override
			protected Map<String, String> getParams() {
				Map<String, String> params = new HashMap<String, String>();
				params.put("location_id", Spn_CityID);

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
		
		/*// On selecting a spinner item
		 String item = parent.getItemAtPosition(position).toString();

		// Showing selected spinner item
		
		  Toast.makeText(parent.getContext(), "Selected: " +
		  Singleton.Spn_CountryName, Toast.LENGTH_LONG) .show();*/
	}

	@Override
	public void onLocationChanged(Location location) {
		// TODO Auto-generated method stub


		float lat = (float) (location.getLatitude());
		float lng = (float) (location.getLongitude());

		Singleton.latitude = lat;
		Singleton.longitude = lng;

		//Location location1 = appLocationService.getLocation(LocationManager.GPS_PROVIDER);
		
		//System.out.println("location1 >> "+location1);

		if (location != null) {
			double latitude = location.getLatitude();
			double longitude = location.getLongitude();
			// LocationAddress locationAddress = new LocationAddress();
			LocationAddress.getAddressFromLocation(latitude, longitude,
					getApplicationContext(), new GeocoderHandler());
		}
		else
		{
			System.out.println(" No location found");
		}
	

	}

	@Override
	public void onStatusChanged(String provider, int status, Bundle extras) {
		// TODO Auto-generated method stub
		
	}

	@Override
	public void onProviderEnabled(String provider) {
		// TODO Auto-generated method stub
		
	}

	@Override
	public void onProviderDisabled(String provider) {
		// TODO Auto-generated method stub
		
	}
	
	private class GeocoderHandler extends Handler {
		@Override
		public void handleMessage(Message message) {
			String locationAddress;
			switch (message.what) {
			case 1:
				Bundle bundle = message.getData();
				locationAddress = bundle.getString("address");
				
				System.out.println("ADDRESS>>>>>>>>>>" + locationAddress );
				Singleton.current_address = locationAddress;
				
				if(Singleton.cityName == null || Singleton.cityName.length() <= 0)
				{					
					loc_pro.setVisibility(View.VISIBLE);
					System.out.println(" City name is NULL ");
				}
				else
				{										
					loc_pro.setVisibility(View.INVISIBLE);
					System.out.println(" City name is NOT NULL ");	
					
				/*	Intent i = new Intent(Choose_spinner_country.this, MainActivity.class);
					startActivity(i);
				*/	
				}
				break;
			default:
				locationAddress = null;
			}
		}
	}
	
	private void getlocation(){
		 recreate();
	}
	
	@Override
	protected void onActivityResult(int requestCode, int resultCode, Intent data) {
		super.onActivityResult(requestCode, resultCode, data);
		
		System.out.println("result code: "+resultCode+"*****"+"Request code++"+requestCode);
		
		 if (requestCode == 2) {
			 
			 System.out.println("is location "+locationManager.isProviderEnabled(LocationManager.GPS_PROVIDER));
	           switch (requestCode) {
	           case 1:
	            	  System.out.println("GPS on");
	            	 
	            	  getlocation();
	               break;
	            }
	         }  else{
	        	 
	        	 System.out.println("GPS off");
	        	 
	         }
	}

}
