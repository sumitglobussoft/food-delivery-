/*package com.globussoft.ziingo;

import android.app.Activity;
import android.app.Dialog;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
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
import android.view.View.OnClickListener;
import android.widget.RelativeLayout;
import android.widget.TextView;

import com.globussoft.ziingo.ui.AppLocationService;
import com.globussoft.ziingo.ui.LocationAddress;
import com.globussoft.ziingo.utills.Singleton;

public class Location_Fetch extends Activity implements LocationListener {

	public RelativeLayout rel_cur_loc, rel_fetching;
	public TextView cur_city, continue_, type_loc;

	private double longitude, latitude;
	private String provider;
	private Location location;
	private AppLocationService appLocationService;
	public LocationManager locationManager;

	// The minimum distance to change Updates in meters
	private static final long MIN_DISTANCE_CHANGE_FOR_UPDATES = 10; // 10 meters
	// The minimum time between updates in milliseconds
	private static final long MIN_TIME_BW_UPDATES = 1000 * 60 * 1; // 1 minute

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		// TODO Auto-generated method stub
		super.onCreate(savedInstanceState);
		setContentView(R.layout.location_fetch);

		InitUI();
	}

	private void InitUI() {

		rel_cur_loc = (RelativeLayout) findViewById(R.id.rel_cur_loc);
		rel_fetching = (RelativeLayout) findViewById(R.id.rel_fetching);
		cur_city = (TextView) findViewById(R.id.your_loc);
		continue_ = (TextView) findViewById(R.id.continue_);
		type_loc = (TextView) findViewById(R.id.type_loc);

		// Get Current Location of User
		appLocationService = new AppLocationService(Location_Fetch.this);
		locationManager = (LocationManager) getSystemService(Context.LOCATION_SERVICE);

		Criteria criteria = new Criteria();
		provider = locationManager.getBestProvider(criteria, false);
		Location location = locationManager.getLastKnownLocation(provider);

		if (Singleton.cityName == null || Singleton.cityName.length() <= 0) {
			if (location != null) {
				rel_fetching.setVisibility(View.INVISIBLE);
				rel_cur_loc.setVisibility(View.VISIBLE);
				cur_city.setText("Current city is " + Singleton.cityName);
				System.out.println("location not null");
				onLocationChanged(location);
			} else {
				rel_fetching.setVisibility(View.VISIBLE);
				rel_cur_loc.setVisibility(View.INVISIBLE);
				System.out.println(" location = null");
				StartGps();
			}
		} else 
		{
			rel_fetching.setVisibility(View.INVISIBLE);
			rel_cur_loc.setVisibility(View.VISIBLE);
			cur_city.setText("Current city is " + Singleton.cityName);
			
		}

		
		continue_.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub

				Intent i = new Intent(Location_Fetch.this, MainActivity.class);
				startActivity(i);

			}
		});

		type_loc.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub

				Intent i = new Intent(Location_Fetch.this, Type_Location.class);
				startActivity(i);
				
				Intent i = new Intent(Location_Fetch.this, MainActivity.class);
				startActivity(i);
			
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
	
	public boolean StartGps() {
		  // Get Location Manager and check for GPS & Network location services
		  LocationManager lm = (LocationManager) getSystemService(LOCATION_SERVICE);
		  if (!lm.isProviderEnabled(LocationManager.GPS_PROVIDER)
		    || !lm.isProviderEnabled(LocationManager.NETWORK_PROVIDER)) {
		   
			  // Build the alert dialog
			  AlertDialog.Builder builder = new AlertDialog.Builder(this);
			  builder.setTitle("Location Services Not Active");
			  builder.setMessage("Please enable Location Services and GPS");
			  builder.setPositiveButton("OK",
					  new DialogInterface.OnClickListener() {
			   
				  public void onClick(DialogInterface dialogInterface,int i) {
					  // Show location settings when the user acknowledges
					  // the alert dialog
					  startActivityForResult(new Intent(Settings.ACTION_LOCATION_SOURCE_SETTINGS), 2);
				  }
			  });
		   
			  Dialog alertDialog = builder.create();
			  alertDialog.setCanceledOnTouchOutside(false);
			  alertDialog.show();
		  
			

			  
				AlertDialog.Builder alertDialog2 = new AlertDialog.Builder(
					    Location_Fetch.this);
					
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
					alertDialog2.setNegativeButton("NO",
					    new DialogInterface.OnClickListener() {
					        public void onClick(DialogInterface dialog, int which) {
					            // Write your code here to execute after dialog
					            
					            dialog.cancel();
					        }
					    });

					// Showing Alert Dialog					
					  Dialog alertDialogg = alertDialog2.create();
					  alertDialog.setCanceledOnTouchOutside(false);
					alertDialog2.show();
	
			  
			  
		  }
		return lm.isProviderEnabled(LocationManager.GPS_PROVIDER)
		    && lm.isProviderEnabled(LocationManager.NETWORK_PROVIDER);
	}
	
	public Location getLocation() {		
		
		
		
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

	@Override
	public void onLocationChanged(Location location) {
		// TODO Auto-generated method stub


		float lat = (float) (location.getLatitude());
		float lng = (float) (location.getLongitude());

		Singleton.latitude = lat;
		Singleton.longitude = lng;

		Location location1 = appLocationService.getLocation(LocationManager.GPS_PROVIDER);
		
		System.out.println("location1 >> "+location1);

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
					rel_fetching.setVisibility(View.VISIBLE);
					rel_cur_loc.setVisibility(View.INVISIBLE);
					System.out.println(" City name empty ");
				}
				else
				{										
					rel_fetching.setVisibility(View.INVISIBLE);
					rel_cur_loc.setVisibility(View.VISIBLE);
					cur_city.setText("Current city is " + Singleton.cityName);
					
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


}*/