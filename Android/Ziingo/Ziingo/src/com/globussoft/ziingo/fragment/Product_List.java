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
import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.AdapterView.OnItemClickListener;
import android.widget.ListView;
import android.widget.Toast;

import com.android.volley.AuthFailureError;
import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.globussoft.ziingo.LoginActivity;
import com.globussoft.ziingo.MainActivity;
import com.globussoft.ziingo.R;
import com.globussoft.ziingo.adapter.HorizontalListAdapter;
import com.globussoft.ziingo.adapter.ProductListAdapter;
import com.globussoft.ziingo.model.ProductListModel;
import com.globussoft.ziingo.model.RestaurantListModel;
import com.globussoft.ziingo.utills.ConstantUrl;
import com.globussoft.ziingo.utills.Singleton;
import com.meetme.android.horizontallistview.HorizontalListView;

public class Product_List extends Fragment {

	private List<ProductListModel> productList = new ArrayList<ProductListModel>();
	private ProductListAdapter plAdapter;
	private ListView listView;

	private List<RestaurantListModel> horizonalList = new ArrayList<RestaurantListModel>();
	private HorizontalListAdapter hlAdapter;
	private HorizontalListView horiListView;
	View rootView;

	@Override
	public View onCreateView(LayoutInflater inflater, ViewGroup container,
			Bundle savedInstanceState) {

		rootView = inflater.inflate(R.layout.product_list, container, false);
		((MainActivity) getActivity()).setTitle(Singleton.category_name);
		InitUi();
		return rootView;
	}

	private void InitUi() {

		listView = (ListView) rootView.findViewById(R.id.list_fooditems);
		horiListView = (HorizontalListView) rootView
				.findViewById(R.id.horizontalListView1);

		plAdapter = new ProductListAdapter(getActivity(), productList);
		listView.setAdapter(plAdapter);

		// hlAdapter = new HorizontalListAdapter(getActivity(), horizonalList);
		hlAdapter = new HorizontalListAdapter(getActivity(),
				Singleton.restaurantListModel);

		horiListView.setAdapter(hlAdapter);

		if(Singleton.category_id == null)
		{
			System.out.println("fetchProductList(  Singleton.cuisine_id  , Singleton.category_type)");
			
			fetchProductList(Singleton.cuisine_id, Singleton.category_type);			
		}
		else
		{
			System.out.println("fetchProductList(  Singleton.category_id  , Singleton.category_type");
			
			fetchProductList(Singleton.category_id, Singleton.category_type);	
			
		}
		
		
		listView.setOnItemClickListener(new OnItemClickListener() {

			@Override
			public void onItemClick(AdapterView<?> parent, View view,
					int position, long id) {
				// TODO Auto-generated method stub

				Singleton.product_id          = productList.get(position).getProduct_id();
				Singleton.product_name        = productList.get(position).getProduct_name();
				Singleton.product_desc        = productList.get(position).getProduct_desc();
				Singleton.product_image       = productList.get(position).getProduct_image();
				Singleton.product_basic_price = productList.get(position).getCost();

				/*
				 * Fragment fragment = new Buy_product(); FragmentManager
				 * fmanager = getActivity() .getSupportFragmentManager();
				 * FragmentTransaction ftans =
				 * fmanager.beginTransaction().replace(R.id.frame_container,
				 * fragment); 
				 //ftans.addToBackStack(null); ftans.commit();
				 */

				Singleton.previousfragment = "Product_List";
				Singleton.currentfragment = "Buy_product";
				
				MainActivity.mManager = getActivity().getSupportFragmentManager();
				MainActivity.swipeFragment(new Buy_product());

				plAdapter = new ProductListAdapter(getActivity(), productList);
				listView.setAdapter(plAdapter);

			}
		});

		horiListView.setOnItemClickListener(new OnItemClickListener() {

			@Override
			public void onItemClick(AdapterView<?> parent, View view,
					int position, long id) {
				// TODO Auto-generated method stub

				if (Singleton.restaurantListModel.get(position).getId() != Singleton.hotel_id) 
				{
					if (!Bag_Fragment.bagModelList.isEmpty()) 
					{
						Singleton.hotel_id = Singleton.restaurantListModel.get(position).getId() ;
						showDialog();
						
						/* Singleton.hotel_id = Singleton.restaurantListModel.get(position).getId() ;
						 MainActivity.mManager = getActivity().getSupportFragmentManager();
						 MainActivity.swipeFragment(new MenuList());*/

					}
					else 
					{   
						Singleton.restaurantListModel.add(Singleton.selectedrest);
					    Singleton.restaurantListModel.remove(position);
					    
						Singleton.hotel_id = Singleton.restaurantListModel.get(position).getId() ;
						Singleton.hotel_name = Singleton.restaurantListModel.get(position).getRest_name();
						Singleton.hotel_img = Singleton.restaurantListModel.get(position).getThumbnailUrl();

						MainActivity.mManager = getActivity().getSupportFragmentManager();
						MainActivity.swipeFragment(new MenuList());

					}
				} 
				
			}
		});

	}

	public void showDialog() {

		AlertDialog.Builder alertDialog2 = new AlertDialog.Builder(
				getActivity());

		alertDialog2.setTitle("Products added in bag will be removed if restaurant is changed. Do you want to proceed ?");
		

		alertDialog2.setPositiveButton("Yes",
				new DialogInterface.OnClickListener() {
					public void onClick(DialogInterface dialog, int which) {
						// Write your code here to execute after dialog

						// dialog and clear cart
						 MainActivity.mManager = getActivity().getSupportFragmentManager();
						 MainActivity.swipeFragment(new MenuList());
						
						Toast.makeText(getActivity(), "Cart Cleared",Toast.LENGTH_SHORT).show();
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

	public void fetchProductList(final String category_id, final String type) {

		productList.clear();
		RequestQueue queue = Volley.newRequestQueue(getActivity()
				.getApplicationContext());
		StringRequest sr = new StringRequest(Request.Method.POST,
				ConstantUrl.Url_main + ConstantUrl.Url_allproducts,
				new Response.Listener<String>() {
					@Override
					public void onResponse(String response) {

						try {
							JSONObject json = new JSONObject(response);

							System.out.println("login response" + response);

							String msg = json.getString("message");
							System.out.println("message >>>>>>>>>" + msg);					
							
							if (json.getString("code").equals("200")) {

								//JSONObject jsonDataObj = json.getJSONObject("data");

								JSONArray jsonMainArr = json.getJSONArray("data");
								
								for (int j = 0; j < jsonMainArr.length(); j++) {

									ProductListModel productModelList = new ProductListModel();

									JSONObject childJSONObject = jsonMainArr.getJSONObject(j);

									productModelList.setProduct_id(childJSONObject.getString("product_id"));
									productModelList.setProduct_name(childJSONObject.getString("name"));
									productModelList.setProduct_desc(childJSONObject.getString("prod_desc"));
									productModelList.setProduct_image(childJSONObject.getString("imagelink"));
									productModelList.setCost(childJSONObject.getString("cost"));

									productList.add(productModelList);

								}

							}

							else {

								Toast.makeText(
										getActivity().getApplicationContext(),
										msg, Toast.LENGTH_LONG).show();
							}

						} catch (Exception e) {
							e.printStackTrace();
						}
						plAdapter.notifyDataSetChanged();

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
				params.put("category_id", category_id);
				params.put("category_type", type);

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

	/*
	 * public void fetchRestHorizontalList() {
		horizonalList.clear();
		RequestQueue queue = Volley.newRequestQueue(getActivity()
				.getApplicationContext());
		StringRequest sr = new StringRequest(Request.Method.GET,
				ConstantUrl.Url_main + ConstantUrl.Url_allhotels,
				new Response.Listener<String>() {
					@Override
					public void onResponse(String response) {

						try 
						{
							JSONObject json = new JSONObject(response);
							System.out.println("login response" + response);

							String msg = json.getString("message");
							System.out.println("message >>>>>>>>>" + msg);

							if (json.getString("code").equals("200")) {

								JSONArray jsonMainArr = json
										.getJSONArray("data");

								for (int j = 0; j < jsonMainArr.length(); j++) {

									RestaurantListModel restListModel = new RestaurantListModel();

									JSONObject childJSONObject = jsonMainArr.getJSONObject(j);

									restListModel.setRest_name(childJSONObject.getString("hotel_name"));
									restListModel.setThumbnailUrl(childJSONObject.getString("hotel_image"));

									horizonalList.add(restListModel);

								}
							}

							else 
							{
								Toast.makeText(getActivity().getApplicationContext(),msg, Toast.LENGTH_LONG).show();
							}

						} 
						catch (Exception e) 
						{
							e.printStackTrace();
						}

						hlAdapter.notifyDataSetChanged();

					}

				}, new Response.ErrorListener() {
					@Override
					public void onErrorResponse(VolleyError error) {
						// VolleyLog.d(TAG, "Error: " + error.getMessage());
						System.out.println("Error : " + error);
						// hidePDialog();

					}
				});

		queue.add(sr);

	}*/

}
