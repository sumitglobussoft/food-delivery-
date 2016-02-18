package com.globussoft.ziingo;

import java.text.SimpleDateFormat;
import java.util.Date;
import java.util.HashMap;
import java.util.Locale;
import java.util.Map;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import android.app.Activity;
import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.location.Criteria;
import android.location.Location;
import android.location.LocationListener;
import android.location.LocationManager;
import android.os.Bundle;
import android.os.Handler;
import android.os.Message;
import android.os.StrictMode;
import android.util.Log;
import android.view.Gravity;
import android.view.View;
import android.view.Window;
import android.widget.Toast;

import com.globussoft.ziingo.R;
import com.globussoft.ziingo.ui.AppLocationService;
import com.globussoft.ziingo.ui.LocationAddress;
import com.globussoft.ziingo.utills.ConstantUrl;
import com.globussoft.ziingo.utills.Singleton;

public class SplashActivity extends Activity implements LocationListener {

	int timeDelay = 2000;

	private Location location;
	private AppLocationService appLocationService;
	private LocationManager locationManager;
	private String provider;
	// The minimum distance to change Updates in meters
	private static final long MIN_DISTANCE_CHANGE_FOR_UPDATES = 10; // 10 meters
	// The minimum time between updates in milliseconds
	private static final long MIN_TIME_BW_UPDATES = 1000 * 60 * 1; // 1 minute
	private double longitude, latitude;

	// private SharedPreferences preferences;
	private SharedPreferences.Editor editor;

	// static boolean login_status = false;

	// private SpotsDialog spotsdialog;

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		this.requestWindowFeature(Window.FEATURE_NO_TITLE);
		StrictMode.ThreadPolicy policy = new StrictMode.ThreadPolicy.Builder().permitAll().build();
		StrictMode.setThreadPolicy(policy);
		setContentView(R.layout.splashscreen);

		// Get Current Location of User
		appLocationService = new AppLocationService(SplashActivity.this);
		locationManager = (LocationManager) getSystemService(Context.LOCATION_SERVICE);
		Criteria criteria = new Criteria();
		provider = locationManager.getBestProvider(criteria, false);
		Location location = locationManager.getLastKnownLocation(provider);

		if (ConstantUrl.isNetworkAvailable(SplashActivity.this)) {
			if (location != null) {
				onLocationChanged(location);
			} else {
				System.out.println("location is null");
			}

		} else {
			System.out.println(" NO internet available");
		}
		
		// date
		SimpleDateFormat dateFormat = new SimpleDateFormat("MM/dd/yyyy",
				Locale.getDefault());
		Date date = new Date();		
		Singleton.date = dateFormat.format(date);
		
		System.out.println("Singleton.date == "+Singleton.date);

		// retrieve data

		SignUpActivity.pref = this.getSharedPreferences("SignUp Credentials", MODE_PRIVATE);

		Singleton.name = SignUpActivity.pref.getString("Username", Singleton.name);
		Singleton.email = SignUpActivity.pref.getString("email", Singleton.email);
		Singleton.pass = SignUpActivity.pref.getString("Password", Singleton.pass);
		Singleton.social_id = SignUpActivity.pref.getString("social_id", Singleton.social_id);
		Singleton.user_id = SignUpActivity.pref.getString("user_id", Singleton.user_id);
		Singleton.signup_status = SignUpActivity.pref.getBoolean("signUp_status", Singleton.signup_status);

		System.out.println("Singleton.signup_status == "+ Singleton.signup_status);

		LoginActivity.pref = this.getSharedPreferences("Ziingo", MODE_PRIVATE);

		Singleton.name = LoginActivity.pref.getString("Username", Singleton.name);
		Singleton.email = LoginActivity.pref.getString("email", Singleton.email);
		Singleton.pass = LoginActivity.pref.getString("Password", Singleton.pass);
		Singleton.social_id = LoginActivity.pref.getString("social_id", Singleton.social_id);
		Singleton.user_id = LoginActivity.pref.getString("user_id", Singleton.user_id);
		Singleton.LoginStatus = LoginActivity.pref.getBoolean("Login_status", Singleton.LoginStatus);

		System.out.println("Singleton.LoginStatus == " + Singleton.LoginStatus);

		Choose_spinner_country.pref = getSharedPreferences("Location_Credentials", MODE_PRIVATE);

		Singleton.Spn_CountryName = Choose_spinner_country.pref.getString("CountryName", Singleton.Spn_CountryName);
		Singleton.Spn_StateName = Choose_spinner_country.pref.getString("StateName", Singleton.Spn_StateName);
		Singleton.Spn_CityName = Choose_spinner_country.pref.getString("CityName", Singleton.Spn_CityName);
		Singleton.Spn_LocationName = Choose_spinner_country.pref.getString("LocationName", Singleton.Spn_LocationName);
		Singleton.Spn_loc_saved = Choose_spinner_country.pref.getBoolean("Spinner_loc", Singleton.Spn_loc_saved);

		System.out.println("Singleton.Spn_loc_saved == "+ Singleton.Spn_loc_saved);

		/*
		 * if(Singleton.LoginStatus == true) { if(Singleton.Spn_loc_saved ==
		 * true) { Intent i = new Intent(SplashActivity.this,
		 * MainActivity.class); startActivity(i); } else { Intent i = new
		 * Intent(SplashActivity.this, MainActivity.class); startActivity(i); }
		 * } else { Intent i = new Intent(SplashActivity.this,
		 * LoginActivity.class); startActivity(i); }
		 */
		
		

		new Handler().postDelayed(new Runnable() {

			@Override
			public void run() {
				/*
				 * Intent intent=new Intent(SplashActivity.this,
				 * Choose_Country.class); startActivity(intent);
				 * 
				 * if (Singleton.user_id != null) {
				 * 
				 * Intent i = new Intent(SplashActivity.this,
				 * Choose_Country.class); startActivity(i);
				 * 
				 * } else {
				 */

				if (Singleton.signup_status == true) 
				{
				    if(Singleton.LoginStatus == true)
				    {
				    	if(Singleton.Spn_loc_saved == true)
				    	{
				    		Intent intent = new Intent(SplashActivity.this, MainActivity.class);
							startActivity(intent);
							finish();
					    	
				    	}
				    	
				    	else
				    	{
				    		Intent intent = new Intent(SplashActivity.this, Choose_spinner_country.class);
							startActivity(intent);
							finish();
				    	}
				    	
				    }
				    else
				    {
				    	Intent intent = new Intent(SplashActivity.this, LoginActivity.class);
						startActivity(intent);
						finish();
				    	
				    }
				} 
				else 
				{
					Intent intent = new Intent(SplashActivity.this, SignUpActivity.class);
					startActivity(intent);
					finish();

				}
				// }
			}

		}, timeDelay);

	}

	@Override
	public void onResume() {
		super.onResume();

		// TODO

		/*
		 * if(ConstantUrl.isNetworkAvailable(SplashActivity.this)){
		 * 
		 * if(login_status)
		 * 
		 * { SignIn();
		 * 
		 * } else { Intent in1 = new
		 * Intent(SplashActivity.this,SignUpActivity.class); startActivity(in1);
		 * 
		 * 
		 * Intent intent=new Intent(SplashActivity.this, Location_Fetch.class);
		 * startActivity(intent);
		 * 
		 * SplashActivity.this.finish(); }
		 * 
		 * } else { Intent intent=new
		 * Intent(SplashActivity.this,CheckNetwork_Activity.class);
		 * startActivity(intent);
		 * 
		 * Toast.makeText(getApplicationContext(), "Please connect to internet",
		 * Toast.LENGTH_SHORT).show(); }
		 */

		// Call to getLocation()

		getLocation();

		locationManager.requestLocationUpdates(provider, 400, 1, this);
	}

	/* Remove the location-listener updates when Activity is paused */
	@Override
	public void onPause() {
		super.onPause();
		locationManager.removeUpdates(this);
	}

	@Override
	public void onLocationChanged(Location location) {

		// TODO Auto-generated method stub
		float lat = (float) (location.getLatitude());
		float lng = (float) (location.getLongitude());

		Singleton.latitude = lat;
		Singleton.longitude = lng;

		Location location1 = appLocationService
				.getLocation(LocationManager.GPS_PROVIDER);

		// double latitude = 37.422005;
		// double longitude = -122.084095

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
				System.out.println("ADDRESS>>>>>>>>>>" + locationAddress);

				Singleton.current_address = locationAddress;

				break;
			default:
				locationAddress = null;
			}
		}
	}

	public Location getLocation() {

		try {
			boolean canGetLocation;
			LocationManager locationManager = (LocationManager) getSystemService(LOCATION_SERVICE);

			// getting GPS status
			boolean isGPSEnabled = locationManager
					.isProviderEnabled(LocationManager.GPS_PROVIDER);

			// getting network status
			boolean isNetworkEnabled = locationManager
					.isProviderEnabled(LocationManager.NETWORK_PROVIDER);

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

}
