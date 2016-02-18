package com.globussoft.ziingo.fragment;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import com.android.volley.AuthFailureError;
import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.globussoft.ziingo.DeliveryAddress_Activity;
import com.globussoft.ziingo.LoginActivity;
import com.globussoft.ziingo.MainActivity;
import com.globussoft.ziingo.R;
import com.globussoft.ziingo.Interface.OnBackPressedListener;
import com.globussoft.ziingo.adapter.BagAdapter;
import com.globussoft.ziingo.adapter.ProductListAdapter;
import com.globussoft.ziingo.adapter.RestaurantListAdapter;
import com.globussoft.ziingo.imageLoader.ImageLoader;
import com.globussoft.ziingo.model.BagModel;
import com.globussoft.ziingo.utills.ConnectionDetector;
import com.globussoft.ziingo.utills.ConstantUrl;
import com.globussoft.ziingo.utills.Singleton;

import android.app.AlertDialog;
import android.app.Dialog;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.SharedPreferences;
import android.content.SharedPreferences.Editor;
import android.os.Bundle;
import android.os.Handler;
import android.support.v4.app.Fragment;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.view.View.OnClickListener;
import android.widget.AdapterView;
import android.widget.AdapterView.OnItemClickListener;
import android.widget.ImageView;
import android.widget.ListView;
import android.widget.ProgressBar;
import android.widget.RelativeLayout;
import android.widget.TextView;
import android.widget.Toast;

public class Bag_Fragment extends Fragment {

	SharedPreferences pref;
	AlertDialog.Builder alert;
	Editor editor;

	int PRIVATE_MODE = 0;

	public static TextView bag_pro_name, bag_pro_price, bag_total, no_bag_items,
			min_order_amt, add_item, sub_total, del_chrg;
	ImageView back_btn;
	RelativeLayout rel_pr_bag, rel_lay;
	// ImageLoader imageloader;

	public static ArrayList<BagModel> bagModelList = new ArrayList<BagModel>();
	public static BagAdapter bag_Adp;
	public ImageView checkout;
	public Handler handler = new Handler();
	boolean isCount_entered = true;
	public ProgressBar progressbar;
	public ListView listView1;
	View rootView;
	
	int cart_ttl_amt;

	@Override
	public View onCreateView(LayoutInflater inflater, ViewGroup container,
			Bundle savedInstanceState) {

		rootView = inflater.inflate(R.layout.bag, container, false);
		// imageloader = new ImageLoader(getActivity());
		System.out.println(" Food Fragment ");
		InitUI();
		return rootView;
	}

	private void InitUI() {

		checkout      = (ImageView) rootView.findViewById(R.id.checkout);
		listView1     = (ListView) rootView.findViewById(R.id.list_bag);
		no_bag_items  = (TextView) rootView.findViewById(R.id.no_bag_items);
		add_item      = (TextView) rootView.findViewById(R.id.additem_text);
		sub_total     = (TextView) rootView.findViewById(R.id.st_amt);
		bag_total     = (TextView) rootView.findViewById(R.id.ttl_amt);
		del_chrg      = (TextView) rootView.findViewById(R.id.dl_amt);
		rel_pr_bag    = (RelativeLayout) rootView.findViewById(R.id.rel_pr_bag);
		min_order_amt = (TextView) rootView.findViewById(R.id.txt_minord);
		
	//	Singleton.previousfragment = "Bag_Fragment";
		
		// arrayList = new ArrayList<BagModel>();
		min_order_amt.setText("Min Order is $" + Singleton.min_order);	
		
		rel_pr_bag.setVisibility(View.INVISIBLE);		
		no_bag_items.setVisibility(View.INVISIBLE);
		
		bag_Adp = new BagAdapter(getActivity(), bagModelList);

		listView1.setAdapter(bag_Adp);
		
		if (bag_Adp.getCount() > 0)
		{
			no_bag_items.setVisibility(View.INVISIBLE);
							
		}	
		

		if (new ConnectionDetector(getActivity()).isConnectingToInternet()) {
			// new BuyProduct().execute();
			if (Singleton.user_id != null) 
			{
				BagProducts(Singleton.user_id);				
				
			} 
			else 
			
			{				
				no_bag_items.setVisibility(View.VISIBLE);
				rel_pr_bag.setVisibility(View.INVISIBLE);
				del_chrg.setText(Singleton.currency +" 0");
				sub_total.setText(Singleton.currency +" 0");
				bag_total.setText(Singleton.currency +" 0");
				
			}

		} 
		else 
		{
			MainActivity.MakeToast("Please check internet connection!!");

		}
		checkout.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View v) {

				isCount_entered = true;

				if (bag_Adp.getCount() > 0) {
					// if (Singleton.user_id != null) {

					// place order service
					/*
					 * MainActivity.mManager=getActivity().getSupportFragmentManager(); 
					 * MainActivity.swipeFragment(new
					 * DeliveryAddress_fragment());
					 * 
					 */
					no_bag_items.setVisibility(View.INVISIBLE);
					
					if((Integer.parseInt(Singleton.cart_total_amt)) >= (Integer.parseInt(Singleton.min_order)))
					{
						min_order_amt.setVisibility(View.GONE);
						Intent intent = new Intent(getActivity(), DeliveryAddress_Activity.class);
						startActivity(intent);
						
					}
					else 
					{
						min_order_amt.setVisibility(View.VISIBLE);
						 ShowDialog1();
					}					

				} 
				else 
				{		
					
					no_bag_items.setVisibility(View.VISIBLE);
					min_order_amt.setVisibility(View.VISIBLE);
					del_chrg.setText(Singleton.currency +" 0");
					sub_total.setText(Singleton.currency +" 0");
					bag_total.setText(Singleton.currency +" 0");
					Toast.makeText(getActivity(), "Please add products", Toast.LENGTH_SHORT).show();
				}
			}
		});

		add_item.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub
				
				 MainActivity.mManager=getActivity().getSupportFragmentManager();
					MainActivity.swipeFragment(new MenuList());

			}
		});

		listView1.setOnItemClickListener(new OnItemClickListener() {

			@Override
			public void onItemClick(AdapterView<?> parent, View view,
					int position, long id) {
				// TODO Auto-generated method stub

				System.out.println("product_sl_no = " + bagModelList.get(position).getBag_product_sl_no());
				System.out.println("product_id = " + bagModelList.get(position).getproduct_id());
				System.out.println("product_name = " + bagModelList.get(position).getBag_product_name());
				System.out.println("product_price = " + bagModelList.get(position).getBag_product_price());
				System.out.println("hotel_id = " + bagModelList.get(position).gethotel_id());
				System.out.println("product_qnt = " + bagModelList.get(position).getBag_product_qnt());

			}
		});
		
	}

	protected void ShowDialog1() {
		// TODO Auto-generated method stub
		
		AlertDialog.Builder alertDialog2 = new AlertDialog.Builder(getActivity());
			
			alertDialog2.setTitle("Total amount is below min order. Please add more products to checkout.");
			
			alertDialog2.setPositiveButton("Ok",
			    new DialogInterface.OnClickListener() {
			        public void onClick(DialogInterface dialog, int which) {		        		
						
						MainActivity.mManager=getActivity().getSupportFragmentManager();
						MainActivity.swipeFragment(new MenuList());
						
						Singleton.previousfragment = "Buy_product";
						Singleton.currentfragment = "";
			          
			        }
			    });

			alertDialog2.setNegativeButton("No",
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

	public void BagProducts(final String user_id) {

		Singleton.product_cartid.clear();
		bagModelList.clear();
		
		del_chrg.setText("$ "+Singleton.delivery_charge);

		RequestQueue queue = Volley.newRequestQueue(getActivity()
				.getApplicationContext());
		StringRequest sr = new StringRequest(Request.Method.POST,
				ConstantUrl.Url_main + ConstantUrl.Url_GetOrdersToCart,
				new Response.Listener<String>() {
					@Override
					public void onResponse(String response) {

						try {
							JSONObject json = new JSONObject(response);

							System.out.println("bag details response"
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
								
								MainActivity.mNotificationsCount = jsonMainArr.length();

								for (int j = 0; j < jsonMainArr.length(); j++) {

									BagModel bagModel = new BagModel();

									JSONObject childJSONObject = jsonMainArr.getJSONObject(j);

									bagModel.setBag_product_sl_no(childJSONObject.getString("cart_id"));

									Singleton.product_sl_no = childJSONObject.getString("cart_id");

									// System.out.println("product_sl_no = "+ Singleton.product_sl_no);

									Singleton.product_cartid.add(Singleton.product_sl_no);

									bagModel.setBag_product_name(childJSONObject.getString("product_name"));
									/*bagModel.sethotel_id(childJSONObject.getString("hotel_id"));*/
									bagModel.setBag_product_qnt(childJSONObject.getString("quantity"));
									bagModel.setBag_product_price(childJSONObject.getString("sub_cost_product"));	
									bagModel.setproduct_id(childJSONObject.getString("product_id"));
									bagModel.setBag_product_image(childJSONObject.getString("imagelink"));

									bagModelList.add(bagModel);

								}

								System.out.println("product_cartid == "+ Singleton.product_cartid); // list
								
								del_chrg.setText(Singleton.currency +" "+Singleton.cart_hotel_del_chrg);
								sub_total.setText(Singleton.currency +" "+Singleton.cart_subtotal_amt);
								
								System.out.println("Singleton.cart_hotel_del_chrg ==== "+Singleton.cart_hotel_del_chrg);
								System.out.println("Integer.parseInt(Singleton.cart_hotel_del_chrg) == "+Integer.parseInt(Singleton.cart_hotel_del_chrg));
								
								cart_ttl_amt = (Integer.parseInt(Singleton.cart_hotel_del_chrg)) + (Integer.parseInt(Singleton.cart_subtotal_amt));
							//	cart_ttl_amt = cart_ttl_amt + Integer.parseInt(Singleton.cart_subtotal_amt);
								Singleton.cart_total_amt = Integer.toString(cart_ttl_amt);
								bag_total.setText(Singleton.currency +" "+Singleton.cart_total_amt);	
								
								if(cart_ttl_amt >= (Integer.parseInt(Singleton.min_order)))
								{
									min_order_amt.setVisibility(View.GONE);
								}
								else 
								{			
									min_order_amt.setVisibility(View.VISIBLE);
								}

								
							}

							else {

								Toast.makeText(getActivity().getApplication(),msg, Toast.LENGTH_SHORT).show();
								rel_pr_bag.setVisibility(View.INVISIBLE);
								no_bag_items.setVisibility(View.VISIBLE);
								
							}

						} 
						catch (Exception e) 
						{
							e.printStackTrace();
						}
						
						rel_pr_bag.setVisibility(View.INVISIBLE);
						bag_Adp.notifyDataSetChanged();

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