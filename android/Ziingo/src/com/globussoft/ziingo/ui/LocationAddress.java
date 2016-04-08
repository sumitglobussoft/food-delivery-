package com.globussoft.ziingo.ui;

import java.io.IOException;
import java.util.List;
import java.util.Locale;

import android.content.Context;
import android.location.Address;
import android.location.Geocoder;
import android.os.Bundle;
import android.os.Handler;
import android.os.Message;
import android.util.Log;

import com.globussoft.ziingo.utills.Singleton;

public class LocationAddress {
	private static final String TAG = "LocationAddress";

    public static void getAddressFromLocation(final double latitude, final double longitude,
                                              final Context context, final Handler handler) {
        Thread thread = new Thread() {
            @Override
            public void run() {
            	
                Geocoder geocoder = new Geocoder(context, Locale.getDefault());
                String result = null;
                try {
                    List<Address> addressList = geocoder.getFromLocation(latitude, longitude, 1);
                    if (addressList != null && addressList.size() > 0) {
                        Address address = addressList.get(0);
                        StringBuilder sb = new StringBuilder();
                        for (int i = 0; i < address.getMaxAddressLineIndex(); i++) {
                            sb.append(address.getAddressLine(i)).append(",");
                        }
                      //  sb.append(address.getLocality()).append(",");
                      //  sb.append(address.getPostalCode()).append(",");
                       
                      //  sb.append(address.getCountryName());
                       // result = sb.toString();
                        
                        result = sb.toString() + address.getCountryName();
                        
                        Singleton.countryName  = address.getCountryName();
                        Singleton.cityName     = address.getLocality();
                        Singleton.stateName    = address.getAdminArea();
                       /* 
                        Singleton.Spn_CountryName = Singleton.countryName  = address.getCountryName();
                        Singleton.Spn_CityName = Singleton.cityName     = address.getLocality();
                        Singleton.Spn_StateName = Singleton.stateName    = address.getAdminArea();*/
                        Singleton.postalCode   = address.getPostalCode();
                       
                        System.out.println("Address == "+ address);
                        System.out.println("StateName == "+Singleton.stateName);
                        System.out.println("CityName == "+  Singleton.cityName);
                        System.out.println("PostalCode == "+ Singleton.postalCode);
                        System.out.println("CountryName == "+ Singleton.countryName);
                       
                    }
                } 
                catch (IOException e) 
                {
                    Log.e(TAG, "Unable connect to Geocoder", e);
                }                 
                
                finally 
                {
                    Message message = Message.obtain();
                    message.setTarget(handler);
                    if (result != null) {
                        message.what = 1;
                        Bundle bundle = new Bundle();
                        
//                        result = "Latitude: " + latitude + " Longitude: " + longitude +
//                                "\n\nAddress:\n" + result;
                      
                                         
                        Singleton.current_address = result;
                       
                        System.out.println("result ==== " + result );
                        bundle.putString("address", result);
                        message.setData(bundle);
                       
                    } else {
                        message.what = 1;
                        Bundle bundle = new Bundle();
                        result = "Latitude: " + latitude + " Longitude: " + longitude +
                                "\n Unable to get address for this lat-long.";
                        bundle.putString("address", result);
                        message.setData(bundle);
                    }
                    message.sendToTarget();
                }
            }
        };
        thread.start();
    }
}
