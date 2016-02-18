package com.globussoft.ziingo.utills;

import android.content.Context;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.util.Log;

public class ConstantUrl {

	
	public static String Url_main="http://api.ziingo.globusapps.com/";
	
	public static String Url_signup="user-authentication?method=signup";
	public static String Url_login = "user-authentication?method=login";
	public static String Url_userprofileinfo = "user-profile?method=userprofileinfo";
	
	public static String Url_allhotels = "hoteldetails?method=allhotels";
	public static String Url_GetMenu = "restaurent-menu-card?method=GetMenu";
	public static String Url_allproducts = "restaurent-menu-card?method=getproductbycategoryId";
	
	public static String Url_InsertOrdersToCart = "addto-cart?method=InsertOrdersToCart";
	public static String Url_GetOrdersToCart = "addto-cart?method=getOrderToCart";	
	public static String Url_RemoveOrderToCart = "addto-cart?method=RemoveOrderToCart";	
	
	public static String Url_insertdeliveryaddress = "user-delivery-settings?method=insertdeliveryaddress";
	public static String Url_updatedeliveryaddress = "user-delivery-settings?method=updatedeliveryaddress";
	
	public static String Url_inserttransaction = "transaction-process?method=inserttransaction";
	public static String Url_updatetransaction = "transaction-process?method=updatetransaction";
		
	public static String Url_insertorders = "orders?method=insertorders";	
	public static String Url_GetOrders = "orders?method=getorders";
	public static String Url_getorderstatus = "hoteldetails?method=getorderstatus";
	
	public static String Url_getcountrys = "get-locations?method=getcountrys";
	public static String Url_getStatesByCountrys = "get-locations?method=getStatesByCountrys";
	public static String Url_getcitysbystates = "get-locations?method=getcitysbystates";
	public static String Url_getlocations = "get-locations?method=getlocations";
	
	public static String Url_getRestaurantsListByLocations = "get-restaurants-list?method=getRestaurantsListByLocations";
	
	public static String Url_getcuisines = "restaurent-menu-card?method=getcuisines";
	public static String Url_fetchbyhotelname = "search-hotels-by?method=hotelname";
	
	public static boolean isNetworkAvailable(Context context) {

		ConnectivityManager connectivity = (ConnectivityManager) context
				.getSystemService(Context.CONNECTIVITY_SERVICE);

		if (connectivity != null) {
			NetworkInfo[] info = connectivity.getAllNetworkInfo();

			if (info != null) {
				for (int i = 0; i < info.length; i++) {
					Log.i("Class", info[i].getState().toString());
					if (info[i].getState() == NetworkInfo.State.CONNECTED) {
						return true;
					}
				}
			}
		}
		return false;
	}
	
}