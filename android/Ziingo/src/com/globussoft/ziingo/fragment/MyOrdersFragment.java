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
import android.view.View.OnClickListener;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.AdapterView.OnItemClickListener;
import android.widget.ListView;
import android.widget.RelativeLayout;
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
import com.globussoft.ziingo.adapter.Order_History_adapter;
import com.globussoft.ziingo.adapter.RestaurantListAdapter;
import com.globussoft.ziingo.model.OrderHistoryModel;
import com.globussoft.ziingo.model.RestaurantListModel;
import com.globussoft.ziingo.utills.ConstantUrl;
import com.globussoft.ziingo.utills.Singleton;

public class MyOrdersFragment extends Fragment 
{
	View rootView;
	private List<OrderHistoryModel> orderHistoryModelList = new ArrayList<OrderHistoryModel>();
	private ListView listView;
	private Order_History_adapter ord_adp;
	private RelativeLayout rel_his_pr;

	@Override
	public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) 
	{
		rootView = inflater.inflate(R.layout.fragment_myorders, container, false);
		InitView();
		return rootView;
	}

	private void InitView() 
	{
		listView = (ListView) rootView.findViewById(R.id.list_myorders);
		rel_his_pr = (RelativeLayout) rootView.findViewById(R.id.rel_his_pr);

		rel_his_pr.setVisibility(View.VISIBLE);

		ord_adp = new Order_History_adapter(getActivity(), orderHistoryModelList);
		listView.setAdapter(ord_adp);

		Singleton.previousfragment = "MyOrders";
		Singleton.currentfragment = "FoodsFragment";

		if (Singleton.user_id != null) 
		{
			fetchOrderHistory(Singleton.user_id, "0", "0"); // work on offset and limits
		} 
		else 
		{
			showLoginDialog();
		}

		listView.setOnItemClickListener(new OnItemClickListener() 
		{
			@Override
			public void onItemClick(AdapterView<?> parent, View view, int position, long id) 
			{	
				Singleton.order_id = orderHistoryModelList.get(position).getHistory_OrderId();

				System.out.println("Singleton.order_id >> "+ Singleton.order_id);

				MainActivity.mManager = getActivity().getSupportFragmentManager();
				MainActivity.swipeFragment(new OrderStatusFragment());

			}
		});
	}

	private void showLoginDialog() 
	{ 
		// TODO Auto-generated method stub
		AlertDialog.Builder alertDialog = new AlertDialog.Builder(getActivity());

		alertDialog.setTitle("Please Login to see your orders.");

		alertDialog.setPositiveButton("Ok", new DialogInterface.OnClickListener() 
		{
			public void onClick(DialogInterface dialog, int which) 
			{
				Intent i = new Intent(getActivity(), LoginActivity.class);
				startActivity(i);

				Singleton.userAtOrderHistory = true;

//				Singleton.previousfragment = "MyOrders";
//				Singleton.currentfragment = "";
			}
			
		});

		alertDialog.setNegativeButton("No", new DialogInterface.OnClickListener() 
		{
			public void onClick(DialogInterface dialog, int which) 
			{
				dialog.cancel();
				
				MainActivity.mManager = getActivity().getSupportFragmentManager();
				MainActivity.swipeFragment(new FoodsFragment());
			}
		});

		// Showing Alert Dialog
		Dialog alertDialog1 = alertDialog.create();
		alertDialog1.setCanceledOnTouchOutside(false);
		alertDialog.show();

	}

	@Override
	public void onResume() 
	{
		// TODO Auto-generated method stub
		super.onResume();
		fetchOrderHistory(Singleton.user_id, "0", "0");
	}

	private void fetchOrderHistory(final String user_id, final String offset,
			final String limit) 
	{
		orderHistoryModelList.clear();

		RequestQueue queue = Volley.newRequestQueue(getActivity().getApplicationContext());
		StringRequest sr = new StringRequest(Request.Method.POST, ConstantUrl.Url_main + ConstantUrl.Url_historyorders,
				new Response.Listener<String>() 
				{
					@Override
					public void onResponse(String response) 
					{
						try 
						{	
							JSONObject json = new JSONObject(response);

							System.out.println("history orders response  >> " + response);

							String msg = json.getString("message");

							System.out.println("message >>>>>>>>>" + msg);

							if (json.getInt("code") == 200) {

								JSONArray jsonMainArr = json.getJSONArray("data");

								for (int j = 0; j < jsonMainArr.length(); j++) 
								{
									JSONObject childJSONObject = jsonMainArr.getJSONObject(j);

									OrderHistoryModel order_historyModel = new OrderHistoryModel();

									order_historyModel.setHistory_OrderId(childJSONObject.getString("order_id"));
									order_historyModel.setHistory_HotelName(childJSONObject.getString("hotel_name"));
									order_historyModel.setHistory_OrderDate(childJSONObject.getString("order_date"));
									order_historyModel.setHistory_HotelAddress(childJSONObject.getString("address"));
									order_historyModel.setHistory_OrderTotal(childJSONObject.getString("total_amount"));

									orderHistoryModelList.add(order_historyModel);
								}
								// sharedPrefernces();
							}

							else 
							{
								Toast.makeText(getActivity().getApplicationContext(), msg, Toast.LENGTH_LONG).show();
							}

						} 
						catch (Exception e) 
						{
							e.printStackTrace();
						}

						if (orderHistoryModelList.size() > 0) 
						{
							rel_his_pr.setVisibility(View.INVISIBLE);
						} 
						else 
						{
							rel_his_pr.setVisibility(View.VISIBLE);
						}
						ord_adp.notifyDataSetChanged();
					}

				}, new Response.ErrorListener() 
				{
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
				Map<String, String> params = new HashMap<String, String>();
				params.put("user_id", user_id);
				params.put("offset", offset);
				params.put("limit", limit);

				return params;
			}

			@Override
			public Map<String, String> getHeaders() throws AuthFailureError 
			{
				Map<String, String> params = new HashMap<String, String>();
				params.put("Content-Type", "application/x-www-form-urlencoded");
				return params;
			}

		};

		queue.add(sr);
	}

}