package com.globussoft.ziingo.fragment;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

import org.json.JSONArray;
import org.json.JSONObject;

import android.graphics.Bitmap;
import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.support.v4.app.FragmentManager;
import android.support.v4.app.FragmentTransaction;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
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
import com.globussoft.ziingo.MainActivity;
import com.globussoft.ziingo.R;
import com.globussoft.ziingo.adapter.BuyProductAdapter;
import com.globussoft.ziingo.adapter.MenuListAdapter;
import com.globussoft.ziingo.adapter.RestaurantListAdapter;
import com.globussoft.ziingo.api.AppController;
import com.globussoft.ziingo.imageLoader.ImageLoader;
import com.globussoft.ziingo.model.ProductListModel;
import com.globussoft.ziingo.model.MenuListModel;
import com.globussoft.ziingo.model.RestaurantListModel;
import com.globussoft.ziingo.utills.ConstantUrl;
import com.globussoft.ziingo.utills.Singleton;

public class MenuList extends Fragment {

	private List<MenuListModel> menuList = new ArrayList<MenuListModel>();
	private MenuListAdapter mlAdapter;
	private ListView listView;
	private TextView restName, cuisine, min_order;
	private ImageView restImage;
	
	ImageLoader imagLoader ;
	View rootView;

	@Override
	public View onCreateView(LayoutInflater inflater, ViewGroup container,
			Bundle savedInstanceState) 
	{

		rootView = inflater.inflate(R.layout.food_menu, container, false);
		imagLoader=new ImageLoader(getActivity());
		InitUi();
		return rootView;
	}

	private void InitUi() 
	{
		restName  = (TextView) rootView.findViewById(R.id.restaurant_name);
		restImage = (ImageView) rootView.findViewById(R.id.logo_thumbnail);
		cuisine   = (TextView) rootView.findViewById(R.id.cuisine);
		min_order = (TextView) rootView.findViewById(R.id.price);
		listView  = (ListView) rootView.findViewById(R.id.list_food);
		
		restName.setText(Singleton.hotel_name);		
		imagLoader.DisplayImage(Singleton.hotel_img, restImage);			

		mlAdapter = new MenuListAdapter(getActivity(), menuList);
		listView.setAdapter(mlAdapter);
		
		min_order.setText(Singleton.currency+Singleton.min_order);
		
		fetchMenuOfHotels(Singleton.hotel_id);

		listView.setOnItemClickListener(new OnItemClickListener() {

			@Override
			public void onItemClick(AdapterView<?> parent, View view,
					int position, long id) {
				// TODO Auto-generated method stub
				
				if(menuList.get(position).getCuisine_Id().isEmpty())
				{
					Singleton.category_id = menuList.get(position).getCategory_Id();
					Singleton.category_type = "menuList";
					Singleton.cuisine_id = null;
					
					System.out.println("Singleton.category_type == "+Singleton.category_type);
				}
				else 
				{
					Singleton.category_id = null;
					Singleton.cuisine_id = menuList.get(position).getCuisine_Id();
					Singleton.category_type = "cuisineList";
					
					System.out.println("Singleton.category_type == "+Singleton.category_type);
				}
				
				Singleton.category_name = menuList.get(position).getCategory_Name();
				
				Singleton.previousfragment = "MenuList";
				Singleton.currentfragment = "Product_List";
				
				MainActivity.mManager=getActivity().getSupportFragmentManager();
				MainActivity.swipeFragment(new Product_List());

				mlAdapter = new MenuListAdapter(getActivity(), menuList);
				listView.setAdapter(mlAdapter);
				
			}
		});

	}

	public void fetchMenuOfHotels(final String hotel_id) 
	{
		menuList.clear();
		
		System.out.println("id "+hotel_id);
		RequestQueue queue = Volley.newRequestQueue(getActivity().getApplicationContext());
		StringRequest sr = new StringRequest(Request.Method.POST,
				ConstantUrl.Url_main + ConstantUrl.Url_GetMenu,
				new Response.Listener<String>() {
					@Override
					public void onResponse(String response) {

						try {
							JSONObject json = new JSONObject(response);

							System.out.println("login response" + response);

							String msg = json.getString("message");
							System.out.println("message >>>>>>>>>" + msg);
							
							System.out.println("Hotel_ID  = "+ Singleton.hotel_id);
							System.out.println("Hotel_Name  = "+ Singleton.hotel_name);

							if (json.getString("code").equals("200")) {								

								JSONObject jsonDataObj = json.getJSONObject("data");
								
								JSONArray jsonMainArr = jsonDataObj.getJSONArray("menuList");

								for (int j = 0; j < jsonMainArr.length(); j++) {
									
									MenuListModel menuModelList = new MenuListModel();

									JSONObject childJSONObject = jsonMainArr.getJSONObject(j);
									
									menuModelList.setId		        (childJSONObject.getString("id"));
									menuModelList.setCategory_Id    (childJSONObject.getString("category_id"));						
									menuModelList.setCategory_Name  (childJSONObject.getString("cat_name"));
									menuModelList.setCategory_Status(childJSONObject.getString("cat_status"));
									menuModelList.setCategory_Desc  (childJSONObject.getString("cat_desc"));
									menuModelList.setLast_Update    (childJSONObject.getString("last_update"));	
									
									menuList.add(menuModelList);									
								}
								
								if(jsonDataObj.has("cuisineList"))
								{
									
								    JSONArray jsonMainArr1 = jsonDataObj.getJSONArray("cuisineList");								    

								    for (int j = 0; j < jsonMainArr1.length(); j++) {
									
									MenuListModel menuModelList = new MenuListModel();

									JSONObject childJSONObject = jsonMainArr1.getJSONObject(j);
									
									menuModelList.setCuisine_Id     (childJSONObject.getString("cuisine_id"));	
									menuModelList.setCategory_Name  (childJSONObject.getString("Cuisine_name"));
									menuModelList.setCategory_Status(childJSONObject.getString("cuisine_status"));
									
									menuList.add(menuModelList);
									
									}
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
						
						mlAdapter.notifyDataSetChanged();

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
				params.put("hotel_id", hotel_id);				

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