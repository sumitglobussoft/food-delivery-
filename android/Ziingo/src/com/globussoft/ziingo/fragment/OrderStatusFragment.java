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
import com.globussoft.ziingo.adapter.OrderStatusAdapter;
import com.globussoft.ziingo.model.OrderStatusModel;
import com.globussoft.ziingo.utills.ConnectionDetector;
import com.globussoft.ziingo.utills.ConstantUrl;
import com.globussoft.ziingo.utills.Singleton;
import com.google.gson.JsonObject;

public class OrderStatusFragment extends Fragment {

	List<String> listDataHeader;
	OrderStatusAdapter OrderStatusAdapter;
	HashMap<String, List<OrderStatusModel>> orderedlistDataChild;
	List<OrderStatusModel> orderstatus = new ArrayList<OrderStatusModel>();
	ExpandableListView expListView;
	RelativeLayout plz_login, main_rel, no_order;

	TextView subtotal, delcharge, hotel_name, hotel_city, del_add, total, date;
	View rootView;

	@Override
	public View onCreateView(LayoutInflater inflater, ViewGroup container,
			Bundle savedInstanceState) {

		rootView = inflater.inflate(R.layout.fragment_orderstatus, container, false);
		InitUi();
		return rootView;
	}

	private void InitUi() {

		hotel_name  = (TextView) rootView.findViewById(R.id.hotel_name);
		hotel_city  = (TextView) rootView.findViewById(R.id.hotel_city);
		del_add     = (TextView) rootView.findViewById(R.id.del_add);
		total       = (TextView) rootView.findViewById(R.id.amt);
		date 		= (TextView) rootView.findViewById(R.id.date);
		subtotal 	= (TextView) rootView.findViewById(R.id.or_txtsubtotal);
		delcharge 	= (TextView) rootView.findViewById(R.id.or_txtdelchrg);
		plz_login 	= (RelativeLayout) rootView.findViewById(R.id.rel_plz_login);
		no_order	= (RelativeLayout) rootView.findViewById(R.id.rel_no_orders);
		main_rel 	= (RelativeLayout) rootView.findViewById(R.id.main_rel);
		expListView = (ExpandableListView) rootView.findViewById(R.id.or_lvExp);
		
		Singleton.previousfragment = "OrderStatus";
		Singleton.currentfragment = "MyOrders";
		

		// check for order_confirmation

		/*if (Singleton.transaction_id != null) 
		{
			main_rel.setVisibility(View.VISIBLE);
			no_order.setVisibility(View.INVISIBLE);*/
		listDataHeader = new ArrayList<String>();

		orderedlistDataChild = new HashMap<String, List<OrderStatusModel>>();
			
			OrderStatusAdapter = new OrderStatusAdapter(getActivity(), listDataHeader, orderedlistDataChild);
			expListView.setAdapter(OrderStatusAdapter);
			
			prepareListData();

			expListView.setOnGroupExpandListener(new OnGroupExpandListener() {

				@Override
				public void onGroupExpand(int groupPosition) 
				{
					// TODO Auto-generated method stub

					OrderStatusAdapter.lblListHeader.setVisibility(View.INVISIBLE); // show item(s)
					OrderStatusAdapter.lblListHeader1.setVisibility(View.VISIBLE);  // hide item(s)

					OrderStatusAdapter.open.setVisibility(View.INVISIBLE);
					OrderStatusAdapter.close.setVisibility(View.VISIBLE);

					subtotal.setVisibility(View.VISIBLE);
					delcharge.setVisibility(View.VISIBLE);
					
					System.out.println("setOnGroupExpandListener");

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
							
							System.out.println("setOnGroupCollapseListener");

						}
				});
			/*		} 
		else 
		{
			main_rel.setVisibility(View.INVISIBLE);
			no_order.setVisibility(View.VISIBLE);

		}
*/
	}

	private void prepareListData() {

		listDataHeader.add("Show item(s)");

		if (new ConnectionDetector(getActivity()).isConnectingToInternet()) 
		{
			if (Singleton.user_id != null) 
			{
				main_rel.setVisibility(View.VISIBLE);
				plz_login.setVisibility(View.INVISIBLE);
				
				System.out.println("Order_Status  >> Singleton.order_id >> "+ Singleton.order_id);

				FetchOrderStatus(Singleton.order_id);

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
	
	private void FetchOrderStatus(final String order_id) 
	{
		System.out.println("*******  order_id ******  "+order_id);
		orderedlistDataChild.clear();

		RequestQueue queue = Volley.newRequestQueue(getActivity().getApplicationContext());
		StringRequest sr = new StringRequest(Request.Method.POST, ConstantUrl.Url_main + ConstantUrl.Url_getorderstatus,
				new Response.Listener<String>() 
				{
					@Override
					public void onResponse(String response) 
					{
						try 
						{
							JSONObject json = new JSONObject(response);

							System.out.println("order staus response"+ response);

							String msg = json.getString("message");
							System.out.println("message >>>>>>>>>" + msg);

							if (json.getString("code").equals("200")) 
							{
								JSONObject obj = json.getJSONObject("data");							
								
								hotel_name.setText(obj.getString("hotel_name"));
								hotel_city.setText(obj.getString("address"));
								delcharge.setText("Delivery charge: " + Singleton.currency + " " + obj.getString("delivery_charge"));
								subtotal.setText("Subtotal: " + Singleton.currency + " "+ obj.getString("total_amount"));
								date.setText(obj.getString("order_date"));
								
								if(obj.getString("address_line1") == null && obj.getString("address_line2") != null )
								{
									del_add.setText(obj.getString("address_line2") + ", " + obj.getString("Location") 								
												+ ", " +"\n"+ obj.getString("landmark")+ ", " + obj.getString("pin")+".");
								}
								else
								{
									del_add.setText(obj.getString("address_line1") + ", " + obj.getString("Location") 								
											+ ", " +"\n"+ obj.getString("landmark")+ ", " + obj.getString("pin")+".");
								}
								
								total.setText(Singleton.currency+ " "
										+ String.valueOf(Integer.parseInt(obj.getString("total_amount"))
										+ Integer.parseInt(obj.getString("delivery_charge"))));

								JSONArray jsonMainArr = obj.getJSONArray("product_detail");

								for (int j = 0; j < jsonMainArr.length(); j++) {

									OrderStatusModel or_statusModel = new OrderStatusModel();

									JSONObject childJSONObject = jsonMainArr.getJSONObject(j);

									or_statusModel.setOs_Pr_name(childJSONObject.getString("name"));
									or_statusModel.setOs_Pr_qnty(childJSONObject.getString("quantity"));
									or_statusModel.setOs_Pr_amt(childJSONObject.getString("product_amount"));

									orderstatus.add(or_statusModel);

								}

								orderedlistDataChild.put(listDataHeader.get(0), orderstatus);

							}

							else 
							{
								System.out.println("msg     "+msg);
								Toast.makeText(getActivity().getApplication(),msg, Toast.LENGTH_SHORT).show();

							}

						} catch (Exception e) {
							e.printStackTrace();
						}

						if(orderedlistDataChild.size()>0)
						{
							OrderStatusAdapter.notifyDataSetChanged();
						}
						else
						{
							
						}				

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
				params.put("order_id", order_id);
				
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
