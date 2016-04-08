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
import com.globussoft.ziingo.Edit_Add_deliverAddress;
import com.globussoft.ziingo.LoginActivity;
import com.globussoft.ziingo.MainActivity;
import com.globussoft.ziingo.R;
import com.globussoft.ziingo.Interface.OnBackPressedListener;
import com.globussoft.ziingo.adapter.New_BagAdapter;
import com.globussoft.ziingo.adapter.ProductListAdapter;
import com.globussoft.ziingo.adapter.RestaurantListAdapter;
import com.globussoft.ziingo.handler.DatabaseHandler;
import com.globussoft.ziingo.imageLoader.ImageLoader;
import com.globussoft.ziingo.model.BagModel;
import com.globussoft.ziingo.model.Edit_del_add_model;
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
import android.util.Log;
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

public class New_Bag_Fragment extends Fragment {

	SharedPreferences pref;
	AlertDialog.Builder alert;
	Editor editor;
	
	DatabaseHandler db;

	int PRIVATE_MODE = 0;
	public static int save_del_add_count;

	public static TextView bag_pro_name, bag_pro_price, bag_total, no_bag_items, 
						   min_order_amt, add_item, sub_total, del_chrg;
	ImageView back_btn;
	public static RelativeLayout rel_pr_bag;
	RelativeLayout rel_lay;
	
	public static List<Edit_del_add_model> edlist = new ArrayList<Edit_del_add_model>();

	public static List<BagModel> bagModelList = new ArrayList<BagModel>();
	public New_BagAdapter bag_Adp;
	public ImageView checkout;
	public Handler handler = new Handler();
	boolean isCount_entered = true;
	public ProgressBar progressbar;
	public static ListView listView1;
	View rootView;

	public static int cart_ttl_amt ;

	@Override
	public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {

		rootView = inflater.inflate(R.layout.bag, container, false);
		InitUI();
		return rootView;
	}
	
	private void InitUI() 
	{
		checkout = (ImageView) rootView.findViewById(R.id.checkout);
		
		listView1 = (ListView) rootView.findViewById(R.id.list_bag);
		
		no_bag_items = (TextView) rootView.findViewById(R.id.no_bag_items);
		add_item = (TextView) rootView.findViewById(R.id.additem_text);
		sub_total = (TextView) rootView.findViewById(R.id.st_amt);
		bag_total = (TextView) rootView.findViewById(R.id.ttl_amt);
		del_chrg = (TextView) rootView.findViewById(R.id.dl_amt);
		rel_pr_bag = (RelativeLayout) rootView.findViewById(R.id.rel_pr_bag);
		min_order_amt = (TextView) rootView.findViewById(R.id.txt_minord);
		
		db = new DatabaseHandler(getActivity());

		Singleton.previousfragment = "Bag_Fragment";
		Singleton.currentfragment = "MenuList";

		min_order_amt.setText("Min Order is " + Singleton.currency + " " + Singleton.min_order);

		rel_pr_bag.setVisibility(View.INVISIBLE);
		no_bag_items.setVisibility(View.INVISIBLE);

		if (Singleton.delivery_charge != null) 
		{
			if(Singleton.user_id != null)
			{
				Bag1(Singleton.user_id, Singleton.hotel_id);
			}
			
			if (bagModelList.size() > 0) 
			{
				cart_ttl_amt = 0;
				
				System.out.println("Singleton.product_total_list : "+Singleton.product_total_list);
				
				for (int i = 0; i < Singleton.product_total_list.size(); i++) 
				{
//					System.out.println("********************");
					cart_ttl_amt += Integer.parseInt(Singleton.product_total_list.get(i));
				}

//				System.out.println("cart_ttl_amt >>> " + cart_ttl_amt);

				Singleton.cart_subtotal_amt = String.valueOf(cart_ttl_amt);
				Singleton.cart_total_amt = String.valueOf((Integer.parseInt(Singleton.delivery_charge)) + cart_ttl_amt);

//				System.out.println("Singleton.cart_subtotal_amt == "+ Singleton.cart_subtotal_amt);
//				System.out.println("Singleton.cart_total_amt == "+ Singleton.cart_total_amt);

				no_bag_items.setVisibility(View.INVISIBLE);
				del_chrg.setText(Singleton.currency + " " + Singleton.delivery_charge);
				sub_total.setText(Singleton.currency + " "+ Singleton.cart_subtotal_amt);
				bag_total.setText(Singleton.currency + " "+ Singleton.cart_total_amt);
				
				if (cart_ttl_amt >= (Integer.parseInt(Singleton.min_order))) 
				{
					min_order_amt.setVisibility(View.GONE);
				} 
				else 
				{
					min_order_amt.setVisibility(View.VISIBLE);
				}
				if (bagModelList.size() > 0) 
				{                              
					bag_Adp = new New_BagAdapter(getActivity(), bagModelList);
					
					listView1.setAdapter(bag_Adp);
					bag_Adp.notifyDataSetChanged();	
					
					no_bag_items.setVisibility(View.INVISIBLE);
				}

			}

			else 
			{
				no_bag_items.setVisibility(View.VISIBLE);
				// min_order_amt.setVisibility(View.VISIBLE);
				del_chrg.setText(Singleton.currency + " 0");
				sub_total.setText(Singleton.currency + " 0");
				bag_total.setText(Singleton.currency + " 0");
				Toast.makeText(getActivity(), "Please add products", Toast.LENGTH_SHORT).show();
			}
		}

		else {
			no_bag_items.setVisibility(View.VISIBLE);
			// min_order_amt.setVisibility(View.VISIBLE);
			del_chrg.setText(Singleton.currency + " 0");
			sub_total.setText(Singleton.currency + " 0");
			bag_total.setText(Singleton.currency + " 0");
			/*Toast.makeText(getActivity(), "Please add products", Toast.LENGTH_SHORT).show();*/
		}	

		checkout.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View v) {
				
				System.out.println("BAGmodelLIST in  checkout >>>>> "+ bagModelList);

				if (new ConnectionDetector(getActivity()).isConnectingToInternet()) 
				{
					if ( bagModelList.size() > 0) 
					{				
						
						if (Singleton.user_id != null || Singleton.social_id != null) 
						{									
							if ((Integer.parseInt(Singleton.cart_total_amt)) >= (Integer.parseInt(Singleton.min_order))) 
							{
								min_order_amt.setVisibility(View.GONE);	
								Bag(Singleton.user_id, Singleton.hotel_id);	
							}

							else 
							{
								min_order_amt.setVisibility(View.VISIBLE);

								ShowDialog1();
							}
							
							/*Bag(Singleton.user_id, Singleton.hotel_id);	*/
							
						}

						else 
						{
							rel_pr_bag.setVisibility(View.INVISIBLE);								

							ShowDialog();
						}
						
					}

					else 
					{
						Toast.makeText(getActivity(), "Please add products", Toast.LENGTH_SHORT).show();
					}
				}

				else 
				{
					MainActivity.MakeToast("Please check internet connection!!");

				}
				
			}
		});

		add_item.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub
				
				if(!Singleton.userFromMenu)
				{
					Intent i = new Intent(getActivity(), MainActivity.class);
					startActivity(i);
					
				}
				
				else
				{
					MainActivity.mManager = getActivity().getSupportFragmentManager();
					MainActivity.swipeFragment(new MenuList());

				}
				
			}
		});

		listView1.setOnItemClickListener(new OnItemClickListener() {

			@Override
			public void onItemClick(AdapterView<?> parent, View view,
					int position, long id) {
				// TODO Auto-generated method stub

				System.out.println("product_id = "+ bagModelList.get(position).getproduct_id());
				System.out.println("product_name = "+ bagModelList.get(position).getBag_product_name());
				System.out.println("product_price = "+ bagModelList.get(position).getBag_product_price());				
				System.out.println("product_qnt = "+ bagModelList.get(position).getBag_product_qnt());
				System.out.println("BAG_product_cartID = "+ bagModelList.get(position).getBag_product_cartid());

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

						MainActivity.mManager = getActivity().getSupportFragmentManager();
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

	public void ShowDialog() {
		// TODO Auto-generated method stub

		AlertDialog.Builder alertDialog = new AlertDialog.Builder(getActivity());

		alertDialog.setTitle("Please login.");

		alertDialog.setPositiveButton("Ok",
				new DialogInterface.OnClickListener() {
					public void onClick(DialogInterface dialog, int which) {

						Intent i = new Intent(getActivity(), LoginActivity.class);
						startActivity(i);

						Singleton.userAtCart = true;

						Singleton.previousfragment = "Bag_Fragment";
						Singleton.currentfragment = "";
						
						if ((Integer.parseInt(Singleton.cart_total_amt)) >= (Integer.parseInt(Singleton.min_order))) 
						{
							min_order_amt.setVisibility(View.GONE);							
						}

						else 
						{
							min_order_amt.setVisibility(View.VISIBLE);

							ShowDialog1();
						}
						
						Bag(Singleton.user_id, Singleton.hotel_id);
						
						

					}
				});

		alertDialog.setNegativeButton("No",
				new DialogInterface.OnClickListener() {
					public void onClick(DialogInterface dialog, int which) {

						dialog.cancel();
					}
				});

		// Showing Alert Dialog
		Dialog alertDialog1 = alertDialog.create();
		alertDialog1.setCanceledOnTouchOutside(false);
		alertDialog.show();

	}

	private void Bag(final String user_id, final String hotel_id) 
	{	 	
//		System.out.println("hotel_id >>>>>>> " + Singleton.hotel_id);
//		System.out.println("delivery_charge >>>>>>> " + Singleton.delivery_charge);
		
		Singleton.productCartid_List.clear();
		Singleton.product_id_list.clear();
		Singleton.product_qnty_list.clear();
		Singleton.product_total_list.clear();
		
		bagModelList.clear();
		bagModelList = db.getAllAddedProducts();
		System.out.println("bag_Adp.getCount() >> "+ bagModelList.size());
		
		RequestQueue queue = Volley.newRequestQueue(getActivity());
		StringRequest sr = new StringRequest(Request.Method.POST,
				ConstantUrl.Url_main + ConstantUrl.Url_GetOrdersToCart,
				new Response.Listener<String>()
				{
					@Override
					public void onResponse(String response) 
					{

						try 
						{
							JSONObject json = new JSONObject(response);

							System.out.println("bag details response" + response);

							String msg = json.getString("message");
							System.out.println("message >>>>>>>>>" + msg);

							if (json.getString("code").equals("200")) 
							{
								
								JSONObject jsonobj = json.getJSONObject("data");
								Singleton.cart_subtotal_amt = jsonobj.getString("subtotal");

								JSONArray jsonMainArr = jsonobj	.getJSONArray("products");
								
								for (int j = 0; j < jsonMainArr.length(); j++) 
								{
									BagModel bagModel = new BagModel();

									JSONObject childJSONObject = jsonMainArr.getJSONObject(j);

									bagModel.setBag_product_cartid(childJSONObject.getString("cart_id"));									
									
									Singleton.product_cart_id = childJSONObject.getString("cart_id");									
									Singleton.productCartid_List.add(Singleton.product_cart_id);
									
									bagModel.setBag_product_name(childJSONObject.getString("product_name"));
									bagModel.setBag_product_qnt(childJSONObject.getString("quantity"));
									bagModel.setBag_product_price(childJSONObject.getString("sub_cost_product"));
									bagModel.setproduct_id(childJSONObject.getString("product_id"));
									bagModel.setBag_product_image(childJSONObject.getString("imagelink"));
									
//									System.out.println("db.getProductId(bagModel.getproduct_id()) >> "
//											+ db.getProductId(bagModel.getproduct_id()));
									
									if(db.getProductId(bagModel.getproduct_id()))
									{
										/*bagModelList.add(db.getProduct(Integer.parseInt(bagModel.getproduct_id())));
										
										 for (BagModel bm : bagModelList) {
									            String log = "Product_Id: "+bm.getproduct_id()
									            		+ " ,Product_Name: " + bm.getBag_product_name() 
									            		+ " ,Product_quantity: " + bm.getBag_product_qnt()
									            		+ " ,Product_totalAmt: " + bm.getBag_product_price()
									            		+ " ,Product_image: " + bm.getBag_product_image();			            
									           
									                // Writing Products to log
									        Log.d("Name: ", log);
										 }
										 */
//										 System.out.println("REPLACED");
									}
									else
									{
										bagModelList.add(bagModel);	
										
//										System.out.println("NOT replaced");
									}
									
								}

							}

							else 
							{
//								Toast.makeText(getActivity(),msg, Toast.LENGTH_SHORT).show();	
							}

						} 
						catch (Exception e) 
						{
							e.printStackTrace();
						}
						
					//	MainActivity.mBagCount = bagModelList.size();
						
//						System.out.println("MainActivity.mBagCount >>> "+ MainActivity.mBagCount);
						
//						System.out.println("bagModelList >>>>>>>> " + bagModelList);
						int cart_subtotal_amt = 0;
						
						for (int i = 0; i < bagModelList.size(); i++)
						{										
							cart_subtotal_amt += Integer.parseInt(bagModelList.get(i).Bag_product_price);
							
							Singleton.product_id_list.add(bagModelList.get(i).product_id);
							Singleton.product_qnty_list.add(bagModelList.get(i).Bag_product_qnt);
							Singleton.product_total_list.add(bagModelList.get(i).Bag_product_price);
						
						}
						 Singleton.cart_subtotal_amt = String.valueOf(cart_subtotal_amt);

						System.out.println("productCartid_List ==== "+ Singleton.productCartid_List); // list
						System.out.println("Singleton.cart_hotel_del_chrg ==== "+ Singleton.delivery_charge);
						System.out.println("Singleton.cart_subtotal_amt ==== "+ Singleton.cart_subtotal_amt);
						
						System.out.println("Singleton.product_id_list == "+Singleton.product_id_list);
						System.out.println("Singleton.product_qnty_list == "+Singleton.product_qnty_list);
						System.out.println("Singleton.product_total_list == "+Singleton.product_total_list);
						
						sub_total.setText(Singleton.currency + " "+ Singleton.cart_subtotal_amt);
						del_chrg.setText(Singleton.currency + " "+ Singleton.delivery_charge);	
						
						cart_ttl_amt = (Integer.parseInt(Singleton.delivery_charge))
								+ (Integer.parseInt(Singleton.cart_subtotal_amt));
					
						Singleton.cart_total_amt = Integer.toString(cart_ttl_amt);
						bag_total.setText(Singleton.currency + " "+ Singleton.cart_total_amt);

						if (cart_ttl_amt >= (Integer.parseInt(Singleton.min_order))) 
						{
							min_order_amt.setVisibility(View.GONE);
						} 
						else
						{
							min_order_amt.setVisibility(View.VISIBLE);
						}	
											
						
				/*		listView1.notify();*/
						 System.out.println("bagModelList.getCount() >> "+ bagModelList.size());
						 
					//	 MainActivity.mBagCount = bagModelList.size();
						
						if (bagModelList.size() > 0) 
						{                              
							bag_Adp = new New_BagAdapter(getActivity(), bagModelList);							
							listView1.setAdapter(bag_Adp);
							
							bag_Adp.notifyDataSetChanged();	
							
							no_bag_items.setVisibility(View.INVISIBLE);
						}
						else
						{
							no_bag_items.setVisibility(View.VISIBLE);
							Toast.makeText(getActivity(),"No items availbale in your bag", Toast.LENGTH_SHORT).show();
						}
						
						
						System.out.println("Checkout :: productCartid_List >> "+ Singleton.productCartid_List);
						
						InsertUpdateAllOrdersToCart(Singleton.user_id,
								Singleton.hotel_id,
								Singleton.product_id_list,
								Singleton.product_qnty_list);

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
	
	private void Bag1(final String user_id, final String hotel_id) 
	{	 	
//		System.out.println("hotel_id >>>>>>> " + Singleton.hotel_id);
//		System.out.println("delivery_charge >>>>>>> " + Singleton.delivery_charge);
		
		Singleton.productCartid_List.clear();
		Singleton.product_id_list.clear();
		Singleton.product_qnty_list.clear();
		Singleton.product_total_list.clear();
		
		bagModelList.clear();
		bagModelList = db.getAllAddedProducts();
		System.out.println("bag_Adp.getCount() >> "+ bagModelList.size());
		
		RequestQueue queue = Volley.newRequestQueue(getActivity());
		StringRequest sr = new StringRequest(Request.Method.POST,
				ConstantUrl.Url_main + ConstantUrl.Url_GetOrdersToCart,
				new Response.Listener<String>()
				{
					@Override
					public void onResponse(String response) 
					{
						try 
						{
							JSONObject json = new JSONObject(response);

//							System.out.println("bag details response" + response);

							String msg = json.getString("message");
//							System.out.println("message >>>>>>>>>" + msg);

							if (json.getString("code").equals("200")) 
							{								
								JSONObject jsonobj = json.getJSONObject("data");
								Singleton.cart_subtotal_amt = jsonobj.getString("subtotal");

								JSONArray jsonMainArr = jsonobj	.getJSONArray("products");
								
								for (int j = 0; j < jsonMainArr.length(); j++) 
								{
									BagModel bagModel = new BagModel();

									JSONObject childJSONObject = jsonMainArr.getJSONObject(j);

									bagModel.setBag_product_cartid(childJSONObject.getString("cart_id"));									
									
									Singleton.product_cart_id = childJSONObject.getString("cart_id");									
									Singleton.productCartid_List.add(Singleton.product_cart_id);
									
									bagModel.setBag_product_name(childJSONObject.getString("product_name"));
									bagModel.setBag_product_qnt(childJSONObject.getString("quantity"));
									bagModel.setBag_product_price(childJSONObject.getString("sub_cost_product"));
									bagModel.setproduct_id(childJSONObject.getString("product_id"));
									bagModel.setBag_product_image(childJSONObject.getString("imagelink"));
									
//									System.out.println("db.getProductId(bagModel.getproduct_id()) >> "
//											+ db.getProductId(bagModel.getproduct_id()));
									
									if(db.getProductId(bagModel.getproduct_id()))
									{
										
									}
									else
									{
										bagModelList.add(bagModel);	
									}									
								}	
							}

							else 
							{
//								Toast.makeText(getActivity(),msg, Toast.LENGTH_SHORT).show();	
							}

						} 
						catch (Exception e) 
						{
							e.printStackTrace();
						}
						
						bag_Adp = new New_BagAdapter(getActivity(), bagModelList);							
						listView1.setAdapter(bag_Adp);
						
						bag_Adp.notifyDataSetChanged();	
						
						//MainActivity.mBagCount = bagModelList.size();
						
//						System.out.println("MainActivity.mBagCount >>> "+ MainActivity.mBagCount);						
//						System.out.println("bagModelList >>>>>>>> " + bagModelList);
						int cart_subtotal_amt = 0;
						
						for (int i = 0; i < bagModelList.size(); i++)
						{										
							cart_subtotal_amt += Integer.parseInt(bagModelList.get(i).Bag_product_price);
							
//							System.out.println("PRODUCT_PRICE (" + i +") >>  " + 
//							Integer.parseInt(bagModelList.get(i).Bag_product_price));
							
							Singleton.product_id_list.add(bagModelList.get(i).product_id);
							Singleton.product_qnty_list.add(bagModelList.get(i).Bag_product_qnt);
							Singleton.product_total_list.add(bagModelList.get(i).Bag_product_price);
						
						}
						 Singleton.cart_subtotal_amt = String.valueOf(cart_subtotal_amt);

						System.out.println("product_cartid ==== "+ Singleton.productCartid_List); // list
						System.out.println("Singleton.cart_hotel_del_chrg ==== "+ Singleton.delivery_charge);
						System.out.println("Singleton.cart_subtotal_amt ==== "+ Singleton.cart_subtotal_amt);
						
						System.out.println("Singleton.product_id_list == "+Singleton.product_id_list);
						System.out.println("Singleton.product_qnty_list == "+Singleton.product_qnty_list);
						System.out.println("Singleton.product_total_list == "+Singleton.product_total_list);
						
						sub_total.setText(Singleton.currency + " "+ Singleton.cart_subtotal_amt);
						del_chrg.setText(Singleton.currency + " "+ Singleton.delivery_charge);	
						
						cart_ttl_amt = (Integer.parseInt(Singleton.delivery_charge))
								+ (Integer.parseInt(Singleton.cart_subtotal_amt));
					
						Singleton.cart_total_amt = Integer.toString(cart_ttl_amt);
						bag_total.setText(Singleton.currency + " "+ Singleton.cart_total_amt);

						if (cart_ttl_amt >= (Integer.parseInt(Singleton.min_order))) 
						{
							min_order_amt.setVisibility(View.GONE);
						} 
						else
						{
							min_order_amt.setVisibility(View.VISIBLE);
						}	
											
						
				/*		listView1.notify();*/
						 System.out.println("bagModelList.getCount() >> "+ bagModelList.size());
						 
						 MainActivity.mBagCount = bagModelList.size();
						
						if (bagModelList.size() > 0) 
						{                              
							//bag_Adp = new New_BagAdapter(getActivity(), bagModelList);							
							//listView1.setAdapter(bag_Adp);
							
							bag_Adp.notifyDataSetChanged();	
							
							no_bag_items.setVisibility(View.INVISIBLE);
						}
						else
						{
							no_bag_items.setVisibility(View.VISIBLE);
							Toast.makeText(getActivity(),"No items available in your bag", Toast.LENGTH_SHORT).show();
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
				params.put("user_id", user_id);
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
	
	private void fetchDeliveryAddress(final String userid)
	{
		RequestQueue queue = Volley.newRequestQueue(getActivity().getApplicationContext());
		StringRequest sr = new StringRequest(Request.Method.POST, ConstantUrl.Url_main + ConstantUrl.Url_fetchdeliveryaddress,
				new Response.Listener<String>()						   
				{
					@Override
					public void onResponse(String response) {

						try {

							JSONObject json = new JSONObject(response);
//							System.out.println("FETCH delivery address response (bag)>> " + response);

							String msg = json.getString("message");
//							System.out.println("message >>>>>>>>>" + msg);

							if (json.getString("code").equals("200")) 
							{
								JSONArray jsonDataArr = json.getJSONArray("data");	
								
								Edit_del_add_model list = new Edit_del_add_model();
								
								save_del_add_count = jsonDataArr.length();
								
									for (int j = 0; j < jsonDataArr.length(); j++) 
									{
										JSONObject jobj = jsonDataArr.getJSONObject(j);	
										
										list.setDel_userName(jobj.getString("user_name"));
										list.setDel_landmark(jobj.getString("landmark"));
										list.setDel_location(jobj.getString("Location"));
										list.setDel_contact_country_code(jobj.getString("contact_country_code"));
										list.setDel_contact_number(jobj.getString("contact_number"));
										list.setDel_address1(jobj.getString("address_line1"));
										list.setDel_address2(jobj.getString("address_line2"));
										list.setDel_city(jobj.getString("district"));
										list.setDel_state(jobj.getString("state"));
										list.setDel_country(jobj.getString("country"));
										list.setDel_pincode(jobj.getString("pin"));
										list.setDel_address_ID(jobj.getString("user_delivery_address_id"));
										
										Singleton.delFullname = jobj.getString("user_name") ;
										Singleton.delAddress = jobj.getString("address_line1");
										Singleton.delLoc = jobj.getString("Location");
										Singleton.delCity = jobj.getString("district");
										Singleton.delpincode = jobj.getString("pin");										
										Singleton.delPh_num = jobj.getString("contact_number");
										Singleton.del_address_ID = jobj.getString("user_delivery_address_id");
										Singleton.delLandMark = jobj.getString("landmark");
										
									}
									
									edlist.add(list);
									
									Intent i = new Intent(getActivity(), Edit_Add_deliverAddress.class);
									startActivity(i);
 																
							}
								
								else if (json.getString("code").equals("197")) 
								{ 
									Intent i = new Intent(getActivity(), DeliveryAddress_Activity.class);
									startActivity(i);									
								}

							}

							
						 catch (JSONException e) {
							// TODO Auto-generated catch block
							e.printStackTrace();
						}

						//bag_Adp.notifyDataSetChanged();

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

				
				params.put("userid", userid);
				
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

	private void InsertUpdateAllOrdersToCart(final String user_id,
			final String hotel_id, final List<String> product_id_list,
			final List<String> product_qnty_list) 
	{
		System.out.println("**** InsertUpdateAllOrdersToCart ***** ");
		
		System.out.println("Singleton.user_id >> "+Singleton.user_id);
		System.out.println("Singleton.hotel_id >> "+Singleton.hotel_id);
		System.out.println("Singleton.product_id_list >> "+Singleton.product_id_list);
		System.out.println("Singleton.product_qnty_list >> "+Singleton.product_qnty_list);
		System.out.println("Singleton.productCartid_List >> "+ Singleton.productCartid_List);
	
		Singleton.productCartid_List.clear();
		
		RequestQueue queue = Volley.newRequestQueue(getActivity() .getApplicationContext());
		StringRequest sr = new StringRequest(Request.Method.POST,ConstantUrl.Url_main 
				         + ConstantUrl.Url_InsertUpdateAllOrdersToCart,
				new Response.Listener<String>() {
					@Override
					public void onResponse(String response) {

						try {

							JSONObject json = new JSONObject(response);
							System.out.println("checkout response : " + response);

							String msg = json.getString("message");
//							System.out.println("message ::>>>>>>>>>" + msg);

							if (json.getString("code").equals("200")) 
							{
								System.out.println("**** InsertUpdateAllOrdersToCart *****  code==200");
								JSONObject jsonDataObj = json.getJSONObject("data");

								if (jsonDataObj.has("fail")) 
								{
									JSONArray mainArr1 = jsonDataObj.getJSONArray("fail");

									for (int j = 0; j < mainArr1.length(); j++) 
									{
										BagModel bagproductList = new BagModel();

										JSONObject chobj = mainArr1.getJSONObject(j);

										bagproductList.setproduct_id(chobj.getString("productId"));
										bagproductList.setproduct_stockQuantity(chobj.getString("stockQuantity"));
										bagproductList.setproduct_orderedQuantity(chobj.getString("orderedQuantity"));

										// bagModelList.add(bagproductList);

									}
 								}

								else if (jsonDataObj.has("success")) {

									JSONArray mainArr = jsonDataObj.getJSONArray("success");

									for (int j = 0; j < mainArr.length(); j++) {

										BagModel bagproductList = new BagModel();
										JSONObject chobj1 = mainArr.getJSONObject(j);

										bagproductList.setBag_product_cartid(chobj1.getString("cartId"));
										bagproductList.setproduct_id(chobj1.getString("productId"));
										bagproductList.setproduct_orderedQuantity(chobj1.getString("orderedQuantity"));

										Singleton.productCartid_List.add(chobj1.getString("cartId"));

										bagModelList.add(bagproductList);

									}
								}

							/*	Toast.makeText(getActivity().getApplicationContext(),"Product inserted to bag ",
										Toast.LENGTH_SHORT).show();*/
								
								fetchDeliveryAddress(Singleton.user_id);

							}

							else 
							{
								System.out.println("**** InsertUpdateAllOrdersToCart *****  code != 200");
								Toast.makeText(getActivity().getApplicationContext(),
										msg, Toast.LENGTH_SHORT).show();
							}

						} catch (JSONException e) {
							// TODO Auto-generated catch block
							e.printStackTrace();
						}

						bag_Adp.notifyDataSetChanged();

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

				JSONArray a = new JSONArray();

				for (int i = 0; i < product_id_list.size(); i++) {

					a.put(product_id_list.get(i));
				}

				JSONArray b = new JSONArray();

				for (int i = 0; i < product_qnty_list.size(); i++) {

					b.put(product_qnty_list.get(i));
				}

				params.put("userid", user_id);
				params.put("hotelid", hotel_id);
				params.put("productid", a.toString());
				params.put("quantity", b.toString());

				System.out.println("user_id" + user_id);
				System.out.println("hotel_id" + hotel_id);
				System.out.println("product_id" + product_id_list);
				System.out.println("product_quantity" + product_qnty_list);

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
