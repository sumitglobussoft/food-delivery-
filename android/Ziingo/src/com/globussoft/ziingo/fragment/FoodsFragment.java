package com.globussoft.ziingo.fragment;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

import org.json.JSONArray;
import org.json.JSONObject;

import android.app.AlertDialog;
import android.app.Dialog;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.SharedPreferences;
import android.content.SharedPreferences.Editor;
import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.view.ContextThemeWrapper;
import android.view.LayoutInflater;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.AdapterView.OnItemClickListener;
import android.widget.ImageView;
import android.widget.ListView;
import android.widget.ProgressBar;
import android.widget.RelativeLayout;
import android.widget.TextView;
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
import com.globussoft.ziingo.adapter.FilterCuisineAdapter;
import com.globussoft.ziingo.adapter.RestaurantListAdapter;
import com.globussoft.ziingo.model.RestaurantListModel;
import com.globussoft.ziingo.utills.ConstantUrl;
import com.globussoft.ziingo.utills.Singleton;

public class FoodsFragment extends Fragment {

	public List<RestaurantListModel> restModelList = new ArrayList<RestaurantListModel>();
	private ListView listView;
	public TextView rest_cnt, location, no_rest, txt_filter;
	public ImageView loc_edit, img_fil_close;
	public ProgressBar progressbar;
	public RelativeLayout rel_pr, rel_filter;
	private RestaurantListAdapter adapter;
	View rootView;
	public String hotel_name;
	public String hotel_id;
	
	// Shared Preferences
	public static SharedPreferences pref;
	Editor editor;
	int PRIVATE_MODE = 0;

	@Override
	public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) 
	{
		rootView = inflater.inflate(R.layout.fragment_foods, container, false);
		System.out.println(" Food Fragment ");
		InitUI();
		return rootView;
	}

	private void InitUI() 
	{
		location = (TextView) rootView.findViewById(R.id.location);
		listView = (ListView) rootView.findViewById(R.id.list_restaurant);
		rest_cnt = (TextView) rootView.findViewById(R.id.rest_cnt);
		loc_edit = (ImageView) rootView.findViewById(R.id.edit);
		no_rest = (TextView) rootView.findViewById(R.id.No_rest);
		rel_pr = (RelativeLayout) rootView.findViewById(R.id.rel_pr);
		rel_filter = (RelativeLayout) rootView.findViewById(R.id.rel_filter);
		txt_filter = (TextView) rootView.findViewById(R.id.txt_filter);
		img_fil_close = (ImageView) rootView.findViewById(R.id.img_fil_close);
		
		rel_pr.setVisibility(View.VISIBLE);
		rel_filter.setVisibility(View.GONE);
	
		adapter = new RestaurantListAdapter(getActivity(), restModelList);
		listView.setAdapter(adapter);

		location.setText(Singleton.Spn_CityName + ", "	+ Singleton.Spn_LocationName);	
		
		//restModelList.clear();
		

		if (Singleton.srch_selected_name != null) 
		{
			FetchHotelsByName(Singleton.srch_selected_name);
		}
		
		else if(Singleton.filter_apply == true)
		{
			Singleton.filter_apply = false;
			rel_filter.setVisibility(View.VISIBLE);
			txt_filter.setText("Filtered by: "+ FilterCuisineAdapter.sstring);
			
			fetchHotel_Cuisine(Singleton.Spn_LocationID, Singleton.filterCusineId_list);
		}
		
		else
		{		
			FetchNearByHotels(Singleton.Spn_CountryID, Singleton.Spn_StateID,
					Singleton.Spn_CityID, Singleton.Spn_LocationID); 
		}
		
		img_fil_close.setOnClickListener(new OnClickListener() {
			
			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub
				rel_filter.setVisibility(View.GONE);
				FetchNearByHotels(Singleton.Spn_CountryID, Singleton.Spn_StateID, Singleton.Spn_CityID, Singleton.Spn_LocationID);
				
			}
		});

		listView.setOnItemClickListener(new OnItemClickListener() {

			@Override
			public void onItemClick(AdapterView<?> parent, View view,
					int position, long id) {
				// TODO Auto-generated method stub
				
				System.out.println("restModelList.get(position).getId() >> "+ restModelList.get(position).getId());
				System.out.println(" Singleton.hotel_id >> "+  Singleton.hotel_id);
				
				if (restModelList.get(position).getId() != Singleton.hotel_id) 
				{					
					if (New_Bag_Fragment.bagModelList.isEmpty()) 
					{						
						System.out.println("id " + restModelList.get(position).getId());

						Singleton.hotel_id        = restModelList.get(position).getId();
						Singleton.hotel_name      = restModelList.get(position).getRest_name();
						Singleton.hotel_img       = restModelList.get(position).getThumbnailUrl();
						Singleton.cuisine         = restModelList.get(position).getCuisine();
						Singleton.min_order   	  = restModelList.get(position).getMin_order();
						Singleton.Rest_address    = restModelList.get(position).getRest_add();
						Singleton.delivery_charge = restModelList.get(position).getDelivery_charge();						
						
					    Singleton.selectedrest = Singleton.restaurantListModel.remove(position);

						System.out.println("Delivery_Charge  >>>> "+ Singleton.delivery_charge);

						/*
						 * Fragment fragment = new MenuList(); FragmentManager fmanager
						 * = getActivity().getSupportFragmentManager();
						 * FragmentTransaction ftans = fmanager.beginTransaction();
						 * ftans.replace(R.id.frame_container, fragment);
						 * //ftans.addToBackStack(null); ftans.commit();
						 */
						
						sharedPrefernces();
						
						Singleton.previousfragment = "FoodsFragment";
						Singleton.currentfragment = "";

						MainActivity.mManager = getActivity().getSupportFragmentManager();
						MainActivity.swipeFragment(new MenuList());						 						 
						 
					}
					
					else 						
					{							
						//showDialog();
						
						Singleton.hotel_id  = restModelList.get(position).getId();
						Singleton.min_order = restModelList.get(position).getMin_order();
						Singleton.Rest_address = restModelList.get(position).getRest_add();
						Singleton.delivery_charge = restModelList.get(position).getDelivery_charge();
						
						sharedPrefernces();
						
						MainActivity.mManager = getActivity().getSupportFragmentManager();
						MainActivity.swipeFragment(new MenuList());
					}
				}
				
				else
				{
					Singleton.hotel_id   = restModelList.get(position).getId();
					Singleton.hotel_name = restModelList.get(position).getRest_name();
					Singleton.hotel_img  = restModelList.get(position).getThumbnailUrl();
					Singleton.cuisine    = restModelList.get(position).getCuisine();
					Singleton.min_order  = restModelList.get(position).getMin_order();
					Singleton.Rest_address = restModelList.get(position).getRest_add();
					Singleton.delivery_charge = restModelList.get(position).getDelivery_charge();
					
					sharedPrefernces();
					
					Singleton.previousfragment = "FoodsFragmentt";
					Singleton.currentfragment  = "MenuList";

					MainActivity.mManager = getActivity().getSupportFragmentManager();
					MainActivity.swipeFragment(new MenuList());
				}
				
			}
		});

		loc_edit.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub

				Intent intent = new Intent(getActivity().getApplication(), Choose_spinner_country.class);
				startActivity(intent);

			}
		});

	}
	
	protected void sharedPrefernces() {

		pref   = this.getActivity().getSharedPreferences("Ziingo", PRIVATE_MODE);
		editor = pref.edit();
		editor.putString("hotel_name", Singleton.hotel_name);
		editor.putString("hotel_address", Singleton.Rest_address);
		editor.putString("hotel_id", Singleton.hotel_id);
		editor.putString("delivery_charge", Singleton.delivery_charge);
		editor.putString("min_order", Singleton.min_order);
		
		editor.commit();

		System.out.println("******** Shared Preference ********");
		System.out.println("selected_hotel_id" + Singleton.hotel_id);
		System.out.println("delivery_charge" + Singleton.delivery_charge);
		System.out.println("Min_order" + Singleton.min_order);
		System.out.println("******** ******** ******** ********");		
		
	}
	
	public void showDialog() {

		AlertDialog.Builder alertDialog2 = new AlertDialog.Builder( new ContextThemeWrapper(getActivity(), R.layout.dialog_reg));
		//	AlertDialog.Builder alertDialog2 = new AlertDialog.Builder( getActivity());
		alertDialog2.setTitle("Products added in bag will be removed if restaurant is changed. Do you want to proceed ?");		

		alertDialog2.setPositiveButton("Yes",
				new DialogInterface.OnClickListener() {
					public void onClick(DialogInterface dialog, int which) {
						// Write your code here to execute after dialog

						// service to clear cart
						
						Toast.makeText(getActivity(), "Cart Cleared", Toast.LENGTH_SHORT).show();
						MainActivity.mManager = getActivity().getSupportFragmentManager();
						MainActivity.swipeFragment(new MenuList());
					}
				});

		alertDialog2.setNegativeButton("NO",
				new DialogInterface.OnClickListener() {
					public void onClick(DialogInterface dialog, int which) {
						// Write your code here to execute after dialog

						dialog.cancel();
					}
				});

		// Showing Alert Dialog
		Dialog alertDialog = alertDialog2.create();
		alertDialog.setCanceledOnTouchOutside(false);
		alertDialog2.show();

	}

	public void FetchNearByHotels(final String CountryID, final String StateID,
			final String CityID, final String LocID) 
	{
		restModelList.clear();
		Singleton.LocRestNameList.clear();
		Singleton.Rest_cuisines.clear();
		
		RequestQueue queue = Volley.newRequestQueue(getActivity().getApplicationContext());
		StringRequest sr = new StringRequest(Request.Method.POST,
				ConstantUrl.Url_main+ ConstantUrl.Url_getRestaurantsListByLocations, new Response.Listener<String>() {
					@Override
					public void onResponse(String response) {

						try {
							JSONObject json = new JSONObject(response);

							System.out.println("restaurant fetch response"+ response);

							String msg = json.getString("message");

							System.out.println("message >>>>>>>>>" + msg);

							if (json.getString("code").equals("200")) {

								JSONArray jsonMainArr = json.getJSONArray("data");

								for (int j = 0; j < jsonMainArr.length(); j++) {

									RestaurantListModel restListModel = new RestaurantListModel();

									JSONObject childJSONObject = jsonMainArr.getJSONObject(j);

									restListModel.setId				(childJSONObject.getString("id"));
									restListModel.setAgent_Id       (childJSONObject.getString("agent_id"));									
									restListModel.setRest_add       (childJSONObject.getString("address"));
									restListModel.setPrimary_phone  (childJSONObject.getString("primary_phone"));
									restListModel.setSecondary_phone(childJSONObject.getString("secondary_phone"));
									restListModel.setRest_name      (childJSONObject.getString("hotel_name"));

									Singleton.LocRestNameList.add(childJSONObject.getString("hotel_name"));
									
									restListModel.setThumbnailUrl   (childJSONObject.getString("hotel_image"));
									restListModel.setOpen_time      (childJSONObject.getString("open_time"));
									restListModel.setClosing_time   (childJSONObject.getString("closing_time"));
									restListModel.setHotel_status   (childJSONObject.getString("hotel_status"));
									restListModel.setNotice         (childJSONObject.getString("notice"));
									restListModel.setMin_order      (childJSONObject.getString("min order"));
									restListModel.setDelivery_charge(childJSONObject.getString("deliverycharge"));

									/*JSONArray arr = childJSONObject.getJSONArray("cuisines_details");
									
									for (int i = 0; i < arr.length(); i++)
									{
										JSONObject innerObject = arr.getJSONObject(i);
										
										RestaurantListModel rst = new RestaurantListModel();
										
										rst.setCuisine(innerObject.getString("Cuisine_name"));
										Singleton.Rest_cuisines.add(rst);
									}*/

									restModelList.add(restListModel);
									Singleton.restaurantListModel = restModelList;	

								}
								
								//sharedPrefernces();

								System.out.println("Singleton.LocRestNameList == "+ Singleton.LocRestNameList);
							}

							else {

								//Toast.makeText(getActivity().getApplicationContext(), msg, Toast.LENGTH_LONG).show();
							}

						} catch (Exception e) 
						{
							e.printStackTrace();
						}

						Singleton.Restaurant_cnt = Integer.toString(restModelList.size());
						rest_cnt.setText(Singleton.Restaurant_cnt);
						System.out.println("Singleton.Restaurant_cnt  >> "+ Singleton.Restaurant_cnt);
						rel_pr.setVisibility(View.INVISIBLE);

						if (restModelList.size() == 0) 
						{
							no_rest.setVisibility(View.VISIBLE);
						} 
						else 
						{
							no_rest.setVisibility(View.INVISIBLE);
						}

						adapter.notifyDataSetChanged();

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
				params.put("country_id", CountryID);
				params.put("state_id", StateID);
				params.put("city_id", CityID);
				params.put("location_id", LocID);

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

	public void FetchHotelsByName(final String srch_selected_name) 	
	{
		restModelList.clear();
		Singleton.Rest_cuisines.clear();
		
		RequestQueue queue = Volley.newRequestQueue(getActivity().getApplicationContext());
		StringRequest sr = new StringRequest(Request.Method.POST,ConstantUrl.Url_main + ConstantUrl.Url_fetchbyhotelname,
				new Response.Listener<String>() {
					@Override
					public void onResponse(String response) {

						try {
							JSONObject json = new JSONObject(response);

							System.out.println("restaurant fetch response"+ response);

							String msg = json.getString("message");

							System.out.println("message >>>>>>>>>" + msg);

							if (json.getString("code").equals("200")) {

								JSONArray jsonMainArr = json.getJSONArray("data");

								for (int j = 0; j < jsonMainArr.length(); j++) {

									RestaurantListModel restListModel = new RestaurantListModel();

									JSONObject childJSONObject = jsonMainArr.getJSONObject(j);

									restListModel.setId             (childJSONObject.getString("id"));
								//	restListModel.setAgent_Id       (childJSONObject.getString("agent_id"));
									restListModel.setHotel_loc_id   (childJSONObject.getString("hotel_location"));
									restListModel.setRest_add       (childJSONObject.getString("address"));
								// restListModel.setPrimary_phone  (childJSONObject.getString("primary_phone"));
								// restListModel.setSecondary_phone(childJSONObject.getString("secondary_phone"));
									restListModel.setRest_name      (childJSONObject.getString("hotel_name"));
									restListModel.setThumbnailUrl   (childJSONObject.getString("hotel_image"));
									restListModel.setOpen_time      (childJSONObject.getString("open_time"));
									restListModel.setClosing_time   (childJSONObject.getString("closing_time"));
									restListModel.setHotel_status   (childJSONObject.getString("hotel_status"));
									restListModel.setNotice         (childJSONObject.getString("notice"));
									restListModel.setMin_order      (childJSONObject.getString("min order"));
									restListModel.setDelivery_charge(childJSONObject.getString("deliverycharge"));
									
									/*JSONArray arr = childJSONObject.getJSONArray("cuisines_details");
									
									for (int i = 0; i < arr.length(); i++)
									{
										JSONObject innerObject = arr.getJSONObject(i);
										
										RestaurantListModel rst = new RestaurantListModel();
										
										rst.setCuisine(innerObject.getString("Cuisine_name"));
										Singleton.Rest_cuisines.add(rst);
										
									}*/

									restModelList.add(restListModel);
									 
									Singleton.restaurantListModel = restModelList;

								}

								System.out.println("Singleton.RestNameList == "+ Singleton.AllRestNameList);
							}

							else {

								Toast.makeText(getActivity().getApplicationContext(),msg, Toast.LENGTH_LONG).show();
							}

						} catch (Exception e) 
						{
							e.printStackTrace();
						}

						Singleton.Restaurant_cnt = Integer.toString(restModelList.size());
						rest_cnt.setText(Singleton.Restaurant_cnt);
						System.out.println("Singleton.Restaurant_cnt  >> "+ Singleton.Restaurant_cnt);
						rel_pr.setVisibility(View.INVISIBLE);

						if (restModelList.size() == 0) 
						{
							no_rest.setVisibility(View.VISIBLE);
						} 
						else 
						{
							no_rest.setVisibility(View.INVISIBLE);
						}

						adapter.notifyDataSetChanged();

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
				params.put("name", srch_selected_name);

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
	
	private void fetchHotel_Cuisine(final String loc_id, final List<String> cuisine_id)
	{
		restModelList.clear();
		Singleton.Rest_cuisines.clear();
		
		RequestQueue queue = Volley.newRequestQueue(getActivity().getApplicationContext());
		StringRequest sr = new StringRequest(Request.Method.POST,ConstantUrl.Url_main + ConstantUrl.Url_fetchhotelbycuisine,
				new Response.Listener<String>() {
					@Override
					public void onResponse(String response) {

						try {
							JSONObject json = new JSONObject(response);

							System.out.println("fetch_rest_cuisine response : "+ response);

							String msg = json.getString("message");

							System.out.println("message >>>>>>>>>" + msg);

							if (json.getInt("code") == 200) {

								JSONArray jsonMainArr = json.getJSONArray("data");

								for (int j = 0; j < jsonMainArr.length(); j++) {

									RestaurantListModel restListModel = new RestaurantListModel();

									JSONObject childJSONObject = jsonMainArr.getJSONObject(j);

									restListModel.setId             (childJSONObject.getString("id"));
									//restListModel.setAgent_Id       (childJSONObject.getString("agent_id"));
									restListModel.setHotel_loc_id   (childJSONObject.getString("hotel_location"));
									restListModel.setRest_add       (childJSONObject.getString("address"));
								//	restListModel.setPrimary_phone  (childJSONObject.getString("primary_phone"));
								//	restListModel.setSecondary_phone(childJSONObject.getString("secondary_phone"));
									restListModel.setRest_name      (childJSONObject.getString("hotel_name"));
									restListModel.setThumbnailUrl   (childJSONObject.getString("hotel_image"));
									restListModel.setOpen_time      (childJSONObject.getString("open_time"));
									restListModel.setClosing_time   (childJSONObject.getString("closing_time"));
									restListModel.setHotel_status   (childJSONObject.getString("hotel_status"));
									restListModel.setNotice         (childJSONObject.getString("notice"));
									restListModel.setMin_order      (childJSONObject.getString("min order"));
									restListModel.setDelivery_charge(childJSONObject.getString("deliverycharge"));
									
									JSONArray arr = childJSONObject.getJSONArray("cuisines_details");
									
									for (int i = 0; i < arr.length(); i++)
									{
										JSONObject innerObject = arr.getJSONObject(i);
										
										RestaurantListModel rst = new RestaurantListModel();
										
										rst.setCuisine(innerObject.getString("Cuisine_name"));
										Singleton.Rest_cuisines.add(rst);
									}

									restModelList.add(restListModel);
									 
									Singleton.restaurantListModel = restModelList;

								}

								System.out.println("Singleton.RestNameList == "+ Singleton.AllRestNameList);
							}

							else {

								Toast.makeText(getActivity().getApplicationContext(),msg, Toast.LENGTH_LONG).show();
							}

						} catch (Exception e) 
						{
							e.printStackTrace();
						}

						Singleton.Restaurant_cnt = Integer.toString(restModelList.size());
						rest_cnt.setText(Singleton.Restaurant_cnt);
						System.out.println("Singleton.Restaurant_cnt  >> "+ Singleton.Restaurant_cnt);
						rel_pr.setVisibility(View.INVISIBLE);

						if (restModelList.size() == 0) 
						{
							no_rest.setVisibility(View.VISIBLE);
						} 
						else 
						{
							no_rest.setVisibility(View.INVISIBLE);
						}

						adapter.notifyDataSetChanged();

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
			protected Map<String, String> getParams() 
			{
				JSONArray a = new JSONArray();

				for (int i = 0; i < cuisine_id.size(); i++) {

					a.put(cuisine_id.get(i));
				}
				Map<String, String> params = new HashMap<String, String>();
				params.put("hotel_locations", loc_id);
				params.put("cuisine_id", a.toString());

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
