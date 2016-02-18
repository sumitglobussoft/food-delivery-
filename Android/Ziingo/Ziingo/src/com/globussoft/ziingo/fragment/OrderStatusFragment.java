package com.globussoft.ziingo.fragment;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

import org.json.JSONArray;
import org.json.JSONObject;

import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ExpandableListView;
import android.widget.ExpandableListView.OnGroupCollapseListener;
import android.widget.ExpandableListView.OnGroupExpandListener;
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
import com.globussoft.ziingo.MainActivity;
import com.globussoft.ziingo.R;
import com.globussoft.ziingo.adapter.FilterCuisineAdapter;
import com.globussoft.ziingo.adapter.OrderStatusAdapter;
import com.globussoft.ziingo.model.BagModel;
import com.globussoft.ziingo.model.FilterModel_Cuisine;
import com.globussoft.ziingo.utills.ConnectionDetector;
import com.globussoft.ziingo.utills.ConstantUrl;
import com.globussoft.ziingo.utills.Singleton;

public class OrderStatusFragment extends Fragment {
	
	List<String> listDataHeader;
	OrderStatusAdapter OrderStatusAdapter;
	HashMap<String, List<BagModel>> orderedlistDataChild;
	List<BagModel> orderstatus = new ArrayList<BagModel>();
	ExpandableListView expListView;
	RelativeLayout plz_login, main_rel;
	
	TextView subtotal, delcharge;
	View rootView;

	@Override
	public View onCreateView(LayoutInflater inflater, ViewGroup container,
			Bundle savedInstanceState) {

		 rootView = inflater.inflate(R.layout.fragment_orderstatus,
				container, false);
        InitUi();
		return  rootView;
	}
	
	private void InitUi() {
		
		TextView hotel_name = (TextView) rootView.findViewById(R.id.hotel_name);
		TextView hotel_city = (TextView) rootView.findViewById(R.id.hotel_city);
		TextView del_add    = (TextView) rootView.findViewById(R.id.del_add);
		TextView total 		= (TextView) rootView.findViewById(R.id.amt);
		TextView date 		= (TextView) rootView.findViewById(R.id.date);		
		subtotal      		= (TextView) rootView.findViewById(R.id.or_txtsubtotal);
		delcharge			= (TextView) rootView.findViewById(R.id.or_txtdelchrg);
		plz_login 			= (RelativeLayout) rootView.findViewById(R.id.rel_plz_login);
		main_rel 			= (RelativeLayout) rootView.findViewById(R.id.main_rel);
		expListView 		= (ExpandableListView) rootView.findViewById(R.id.or_lvExp);
		
		//check for order_confirmation
		
		hotel_name.setText(Singleton.hotel_name);
		hotel_city.setText(Singleton.Rest_address);
		del_add.setText   (Singleton.delAddress + ", " + Singleton.Spn_CityName + ", " + Singleton.Spn_StateName +".");
		total.setText     (Singleton.currency +" "+ Singleton.cart_total_amt);
		date.setText      (Singleton.date);
		subtotal.setText  ("Subtotal: "+Singleton.currency + " " +Singleton.cart_subtotal_amt);
		delcharge.setText ("Delivery charge: "+Singleton.currency+ " " + Singleton.cart_hotel_del_chrg);
		
		prepareListData();
		
		OrderStatusAdapter = new OrderStatusAdapter(getActivity(), listDataHeader, orderedlistDataChild);
		expListView.setAdapter(OrderStatusAdapter);
		
		expListView.setOnGroupExpandListener(new OnGroupExpandListener() {
			
			@Override
			public void onGroupExpand(int groupPosition) {
				// TODO Auto-generated method stub
				
				OrderStatusAdapter.lblListHeader.setVisibility(View.INVISIBLE);
				OrderStatusAdapter.lblListHeader1.setVisibility(View.VISIBLE);
				
				OrderStatusAdapter.open.setVisibility(View.INVISIBLE);
				OrderStatusAdapter.close.setVisibility(View.VISIBLE);
				
				subtotal.setVisibility(View.VISIBLE);
				delcharge.setVisibility(View.VISIBLE);
				
			}
		});
		
		expListView.setOnGroupCollapseListener(new OnGroupCollapseListener() {
			
			@Override
			public void onGroupCollapse(int groupPosition) {
				// TODO Auto-generated method stub
				OrderStatusAdapter.lblListHeader.setVisibility(View.VISIBLE);
				OrderStatusAdapter.lblListHeader1.setVisibility(View.INVISIBLE);
				
				OrderStatusAdapter.open.setVisibility(View.VISIBLE);
				OrderStatusAdapter.close.setVisibility(View.INVISIBLE);
				
				subtotal.setVisibility(View.INVISIBLE);
				delcharge.setVisibility(View.INVISIBLE);
				
			}
		});
	}
	
	private void prepareListData() {
		
		listDataHeader = new ArrayList<String>();		

		orderedlistDataChild = new HashMap<String, List<BagModel>>();

		listDataHeader.add("Show item(s)");	
		
		if (new ConnectionDetector(getActivity()).isConnectingToInternet()) {
			// new BuyProduct().execute();
			if (Singleton.user_id != null) 
			{
				main_rel.setVisibility(View.VISIBLE);
				plz_login.setVisibility(View.INVISIBLE);

				getOrderStatus(Singleton.user_id);				
				
			} 
			else 
			
			{	
				main_rel.setVisibility(View.INVISIBLE);
				plz_login.setVisibility(View.VISIBLE);
				Toast.makeText(getActivity(), "Please log in ", Toast.LENGTH_SHORT).show();
				
			}

		} 
		else 
		{
			MainActivity.MakeToast("Please check internet connection!!");

		}		

	}
	
	
	private void getOrderStatus(final String user_id) {

		orderedlistDataChild.clear();

		RequestQueue queue = Volley.newRequestQueue(getActivity().getApplicationContext());
		StringRequest sr = new StringRequest(Request.Method.POST,
				ConstantUrl.Url_main + ConstantUrl.Url_GetOrdersToCart,
				new Response.Listener<String>() {
					@Override
					public void onResponse(String response) {

						try {
							JSONObject json = new JSONObject(response);

							System.out.println("order staus response"
									+ response);

							String msg = json.getString("message");
							System.out.println("message >>>>>>>>>" + msg);

							if (json.getString("code").equals("200")) {
								
								JSONObject jsonobj = json.getJSONObject("data");
								
								Singleton.cart_hotel_name = jsonobj.getString("hotel_name");
								Singleton.cart_hotel_id = jsonobj.getString("hotel_id");
								Singleton.cart_hotel_del_chrg = jsonobj.getString("deliverycharge");
								Singleton.cart_subtotal_amt = jsonobj.getString("subtotal");
								
								System.out.println("Singleton.cart_hotel_del_chrg ==== "+ Singleton.cart_hotel_del_chrg);

								JSONArray jsonMainArr = jsonobj	.getJSONArray("products");

								for (int j = 0; j < jsonMainArr.length(); j++) {

									BagModel bagModel = new BagModel();

									JSONObject childJSONObject = jsonMainArr.getJSONObject(j);									

									bagModel.setBag_product_name(childJSONObject.getString("product_name"));								
									bagModel.setBag_product_qnt(childJSONObject.getString("quantity"));
									bagModel.setBag_product_price(childJSONObject.getString("sub_cost_product"));										

									orderstatus.add(bagModel);

								}
								
								orderedlistDataChild.put(listDataHeader.get(0), orderstatus);
								
							}

							else {

								Toast.makeText(getActivity().getApplication(),msg, Toast.LENGTH_SHORT).show();
								
							}

						} catch (Exception e) {
							e.printStackTrace();
						}
						
						OrderStatusAdapter.notifyDataSetChanged();


					}

				}, new Response.ErrorListener() {
					@Override
					public void onErrorResponse(VolleyError error) {
						// VolleyLog.d(TAG, "Error: " + error.getMessage());
						System.out.println("Error : " + error);
						

					}
				}) {
			@Override
			protected Map<String, String> getParams() {
				Map<String, String> params = new HashMap<String, String>();
				params.put("user_id", user_id);

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
