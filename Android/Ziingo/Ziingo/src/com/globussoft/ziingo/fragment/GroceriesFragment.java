package com.globussoft.ziingo.fragment;

import java.util.HashMap;
import java.util.Map;

import org.json.JSONArray;
import org.json.JSONObject;

import android.content.Intent;
import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.view.View.OnClickListener;
import android.widget.AdapterView;
import android.widget.ImageView;
import android.widget.ListView;
import android.widget.RelativeLayout;
import android.widget.TextView;
import android.widget.Toast;
import android.widget.AdapterView.OnItemClickListener;

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
import com.globussoft.ziingo.adapter.RestaurantListAdapter;
import com.globussoft.ziingo.model.RestaurantListModel;
import com.globussoft.ziingo.utills.ConstantUrl;
import com.globussoft.ziingo.utills.Singleton;

public class GroceriesFragment extends Fragment 
{
	
	 @Override
	    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) 
	 {
	  
	        View rootView = inflater.inflate(R.layout.fragment_groceries, container, false);
	        //  InitUI();
	        return rootView;
	    }
	 
/*	 private void InitUI()
	 {

			location = (TextView) rootView.findViewById(R.id.location);
			listView = (ListView) rootView.findViewById(R.id.list_restaurant);
			rest_cnt = (TextView) rootView.findViewById(R.id.rest_cnt);
			loc_edit = (ImageView) rootView.findViewById(R.id.edit);
			//progressbar = (ProgressBar) rootView.findViewById(R.id.progressBar1);
			no_rest = (TextView) rootView.findViewById(R.id.No_rest);
			rel_pr = (RelativeLayout) rootView.findViewById(R.id.rel_pr); 
			rel_pr.setVisibility(View.VISIBLE);
			
			adapter = new RestaurantListAdapter(getActivity(), restModelList);
			listView.setAdapter(adapter);
			
			location.setText(Singleton.Spn_CityName +", "+Singleton.Spn_LocationName);
			
			FetchNearByGrocery(Singleton.Spn_CountryID, Singleton.Spn_StateID,
					Singleton.Spn_CityID, Singleton.Spn_LocationID);  // pass LOCATION as Params					
			
			
			listView.setOnItemClickListener(new OnItemClickListener() 
			{

				@Override
				public void onItemClick(AdapterView<?> parent, View view,int position, long id) 
				{
					// TODO Auto-generated method stub
					System.out.println("id "+restModelList.get(position).getId());
					
					Singleton.hotel_id=restModelList.get(position).getId();
					Singleton.hotel_name=restModelList.get(position).getRest_name();
					Singleton.hotel_img=restModelList.get(position).getThumbnailUrl();
					Singleton.cuisine=restModelList.get(position).getCuisine();
					Singleton.min_order=restModelList.get(position).getMin_order();
					Singleton.delivery_charge=restModelList.get(position).getDelivery_charge();
					
					System.out.println("Delivery_Charge  >>>> "+ Singleton.delivery_charge);
					
					Fragment fragment = new MenuList();
					FragmentManager fmanager = getActivity().getSupportFragmentManager();
					FragmentTransaction ftans = fmanager.beginTransaction();
					ftans.replace(R.id.frame_container, fragment);
					//ftans.addToBackStack(null);
					ftans.commit();		
					
			        MainActivity.mManager=getActivity().getSupportFragmentManager();
					MainActivity.swipeFragment(new MenuList());
				
					
				}
			});
			
			loc_edit.setOnClickListener(new OnClickListener() {
				
				@Override
				public void onClick(View v) {
					// TODO Auto-generated method stub
					
					Intent i = new Intent(getActivity(), Choose_spinner_country.class);
					startActivity(i);
					
				}
			});
		
	 }
	 
	 public void FetchNearByGrocery(final String CountryID, final String StateID, final String CityID, final String LocID) {
			
			restModelList.clear();
			RequestQueue queue = Volley.newRequestQueue(getActivity()
					.getApplicationContext());
			StringRequest sr = new StringRequest(Request.Method.POST,
					ConstantUrl.Url_main + ConstantUrl.Url_getRestaurantsListByLocations,
					new Response.Listener<String>() {
						@Override
						public void onResponse(String response) {		
							

							
								try {
									JSONObject json = new JSONObject(response);

									System.out.println("restaurant fetch response" + response);

									String msg = json.getString("message");
									
									System.out.println("message >>>>>>>>>" + msg);

									if (json.getString("code").equals("200")) {

										
										JSONArray jsonMainArr = json.getJSONArray("data");


										for (int j = 0; j < jsonMainArr.length(); j++) {
											
											RestaurantListModel restListModel = new RestaurantListModel();
											
											JSONObject childJSONObject = jsonMainArr
													.getJSONObject(j);

											restListModel.setId(childJSONObject
													.getString("id"));	
																				
											restListModel
													.setAgent_Id(childJSONObject
															.getString("agent_id"));
											restListModel
													.setAgent_Fullname(childJSONObject
															.getString("owner_fname"));
											restListModel
													.setAgent_Lastname(childJSONObject
															.getString("owner_lname"));
											restListModel.setCity(childJSONObject
													.getString("hotel_city"));
											restListModel.setState(childJSONObject
													.getString("hotel_state"));
											restListModel
													.setCountry(childJSONObject
															.getString("hotel_country"));
											restListModel
													.setRest_add(childJSONObject
															.getString("address"));
											restListModel
													.setPrimary_phone(childJSONObject
															.getString("primary_phone"));
											restListModel
													.setSecondary_phone(childJSONObject
															.getString("secondary_phone"));
											restListModel.setRest_name(childJSONObject
													.getString("hotel_name"));
										
											restListModel
													.setThumbnailUrl(childJSONObject
															.getString("hotel_image"));
											restListModel.setOpen_time(childJSONObject
													.getString("open_time"));
											restListModel
													.setClosing_time(childJSONObject
															.getString("closing_time"));
											restListModel
													.setHotel_status(childJSONObject
															.getString("hotel_status"));
											restListModel.setNotice(childJSONObject
													.getString("notice"));
											restListModel.setMin_order(childJSONObject
													.getString("min order"));
											restListModel.setDelivery_charge(childJSONObject
													.getString("deliverycharge"));
											restListModel.setEmail(childJSONObject
													.getString("email"));
											restListModel.setHotel_loc(childJSONObject
													.getString("hotel_location"));
											restListModel.setHotel_loc_id(childJSONObject
													.getString("location_id"));
											restListModel.setHotel_loc_type(childJSONObject
													.getString("location_type"));
											restListModel.setHotel_loc_status(childJSONObject
													.getString("location_status"));
											restListModel.setNotice(childJSONObject
													.getString("membership"));
											
											restListModel.setCuisine(childJSONObject
													.getString("Cuisine"));

											restModelList.add(restListModel);
											
										}
									}

									else {

										Toast.makeText(
												getActivity()
														.getApplicationContext(),
												msg, Toast.LENGTH_LONG).show();
									}

								} catch (Exception e) {
									e.printStackTrace();
								}
								
								Singleton.Restaurant_cnt=Integer.toString(restModelList.size());
								rest_cnt.setText(Singleton.Restaurant_cnt);	
								System.out.println("Singleton.Restaurant_cnt  >> "+Singleton.Restaurant_cnt);
								rel_pr.setVisibility(View.INVISIBLE);
								
								if(restModelList.size() == 0)
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
		}*/
	 

}