package com.globussoft.ziingo.fragment;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import android.app.AlertDialog;
import android.app.Dialog;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.SharedPreferences;
import android.content.SharedPreferences.Editor;
import android.os.Bundle;
import android.provider.Settings;
import android.support.v4.app.Fragment;
import android.view.LayoutInflater;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.ViewGroup;
import android.view.Window;
import android.webkit.WebView.FindListener;
import android.widget.ImageView;
import android.widget.LinearLayout;
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
import com.globussoft.ziingo.Location_Fetch;
import com.globussoft.ziingo.LoginActivity;
import com.globussoft.ziingo.MainActivity;
import com.globussoft.ziingo.R;
import com.globussoft.ziingo.adapter.BuyProductAdapter;
import com.globussoft.ziingo.adapter.RestaurantListAdapter;
import com.globussoft.ziingo.imageLoader.ImageLoader;
import com.globussoft.ziingo.model.BuyProductModel;
import com.globussoft.ziingo.model.BuyProductModel;
import com.globussoft.ziingo.model.MenuListModel;
import com.globussoft.ziingo.model.RestaurantListModel;
import com.globussoft.ziingo.utills.ConstantUrl;
import com.globussoft.ziingo.utills.Singleton;

public class Buy_product extends Fragment {

	private List<BuyProductModel> buyProductModelList = new ArrayList<BuyProductModel>();
	private BuyProductAdapter bpAdapter;
	View rootView;
	ImageView thumbNail, plus, minus;
	TextView product_name, product_desc, basic_price, qnt_cnt, total, addToBag,
			subtotal, delivery_charge;
	// AlertDialog alert;
	AlertDialog.Builder alert;

	int i = 1;
	int food_subtotal_amt;
	int food_total_amt;
	BuyProductModel buyProductModel = new BuyProductModel();

	ImageLoader imageloader;

	// Shared Preferences
	SharedPreferences pref;

	// Editor for Shared preferences
	Editor editor;

	// Shared pref mode
	int PRIVATE_MODE = 0;

	@Override
	public View onCreateView(LayoutInflater inflater, ViewGroup container,
			Bundle savedInstanceState) {

		rootView = inflater.inflate(R.layout.buy_food, container, false);
		imageloader = new ImageLoader(getActivity());
		((MainActivity)getActivity()).setTitle(Singleton.product_name);
		InitUI();
		return rootView;
	}

	protected void sharedPrefernces() {

		pref = this.getActivity().getSharedPreferences(
				"BuyProduct Credentials", PRIVATE_MODE);
		editor = pref.edit();
		editor.putString("foodQuantity", Singleton.product_quantity);
		editor.putString("foodSubTotalAmount", Singleton.product_subtotal);
		editor.putString("foodTotalAmount", Singleton.product_totalAmt);
		editor.putString("foodDeliveryCharge", Singleton.delivery_charge);
		editor.commit();

		System.out.println("******** Shared Preference ********");
		System.out.println("foodQuantity" + Singleton.product_quantity);
		System.out.println("foodTotalAmount" + Singleton.product_totalAmt);
		System.out.println("foodSubTotalAmount" + Singleton.product_subtotal);
		System.out.println("foodDeliveryCharge" + Singleton.delivery_charge);
		System.out.println("******** ******** ******** ********");
		
		
	}

	private void InitUI() {

		thumbNail    = (ImageView) rootView.findViewById(R.id.buy_food_image);
		product_name = (TextView) rootView.findViewById(R.id.fooditem_name);
		product_desc = (TextView) rootView.findViewById(R.id.food_desc);
		basic_price  = (TextView) rootView.findViewById(R.id.basicprice_amt);
		total        = (TextView) rootView.findViewById(R.id.total);
		plus         = (ImageView) rootView.findViewById(R.id.plus_qnt);
		minus        = (ImageView) rootView.findViewById(R.id.minus_qnt);
		qnt_cnt 	 = (TextView) rootView.findViewById(R.id.qnty_cnt);
		addToBag     = (TextView) rootView.findViewById(R.id.addtobag);
	  //subtotal     = (TextView) rootView.findViewById(R.id.sub_total);
	  //delivery_charge = (TextView) rootView.findViewById(R.id.del_chrg);

		Singleton.previousfragment = "Buy_product";
		Singleton.currentfragment = "";
		
		qnt_cnt.setText(Integer.toString(i));
		Singleton.product_quantity = qnt_cnt.getText().toString();
		
		System.out.println("Initial Quantity ====  " + Singleton.product_quantity);

		bpAdapter = new BuyProductAdapter(getActivity(), buyProductModelList);

		// fetchProductDescription(Singleton.product_id);

		product_name.setText(Singleton.product_name);
		product_desc.setText(Singleton.product_desc);
		basic_price.setText("$ "+Singleton.product_basic_price);
		imageloader.DisplayImage(Singleton.product_image, thumbNail);
		total.setText("$ " +Singleton.product_basic_price);
		//delivery_charge.setText(Singleton.delivery_charge);
		//subtotal.setText(Singleton.product_basic_price);		

		//Singleton.product_subtotal = subtotal.getText().toString();
		//Singleton.delivery_charge = delivery_charge.getText().toString();

		/*food_total_amt = Integer.parseInt(Singleton.product_subtotal) + Integer.parseInt(Singleton.delivery_charge);
		Singleton.product_totalAmt = Integer.toString(food_total_amt);
		total.setText(Singleton.product_totalAmt);*/

		System.out.println("product_subtotal >>> " + Singleton.product_subtotal);

		plus.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub
				System.out.println(" ++++ Plus Clicked ++++");

				i++;
				qnt_cnt.setText(Integer.toString(i));
				System.out.println("Increased Quantity  ====  "
						+ Integer.toString(i));

				//food_subtotal_amt = Integer.parseInt(Singleton.product_basic_price) * i;

				//subtotal.setText(Integer.toString(food_subtotal_amt));
				//Singleton.product_subtotal = subtotal.getText().toString();
				Singleton.product_quantity = qnt_cnt.getText().toString();				

				/*food_total_amt = Integer.parseInt(Singleton.product_subtotal)
						+ Integer.parseInt(Singleton.delivery_charge);*/
				
				food_total_amt = Integer.parseInt(Singleton.product_basic_price) * i;
				Singleton.product_totalAmt = Integer.toString(food_total_amt);
				total.setText("$ "+Singleton.product_totalAmt);

				sharedPrefernces();

			}
		});

		minus.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub
				if (i > 1) {

					i--;
					qnt_cnt.setText(Integer.toString(i));
					System.out.println("Decreased Quantity  ====  " + Integer.toString(i));

					/*food_subtotal_amt = Integer.parseInt(Singleton.product_basic_price) * i;

					subtotal.setText(Integer.toString(food_subtotal_amt));
					Singleton.product_subtotal = subtotal.getText().toString();
					Singleton.product_quantity = qnt_cnt.getText().toString();

					System.out.println("product_quantity >> "+ Singleton.product_quantity);
					System.out.println("product_subtotal >> "+ Singleton.product_subtotal);
					System.out.println("delivery_charge >> "+ Singleton.delivery_charge);
					System.out.println("Image   >>>> " + Singleton.product_image);

					food_total_amt = Integer.parseInt(Singleton.product_subtotal)+ Integer.parseInt(Singleton.delivery_charge);
					Singleton.product_totalAmt = Integer.toString(food_total_amt);
					total.setText(Singleton.product_totalAmt);
					
					*/
					
					
					food_total_amt = Integer.parseInt(Singleton.product_basic_price) * i;
					Singleton.product_totalAmt = Integer.toString(food_total_amt);
					total.setText("$ "+Singleton.product_totalAmt);

					sharedPrefernces();

				} 
				else 
				{
					Toast.makeText(getActivity(), "Quantity cannot be reduced below one",
							Toast.LENGTH_LONG).show();

				}

			}
		});

		addToBag.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub

				//if (Singleton.firstName != null) {
				if (Singleton.user_id != null || Singleton.social_id !=null) {										
								
					// add product to bad			
					
					AddToBag(Singleton.user_id, Singleton.hotel_id, Singleton.product_id, Singleton.product_quantity);
					
					System.out.println("Product added to bag");
					
					// Bag notification badge
					
					sharedPrefernces();
				} 
				
				else 
				{
					ShowDialog1();
				}

			}
		});

	}

		
	public void AddToBag(final String user_id, final String hotel_id, final String product_id, final String product_quantity) {

		RequestQueue queue = Volley.newRequestQueue(getActivity().getApplicationContext());
		StringRequest sr = new StringRequest(Request.Method.POST,
				ConstantUrl.Url_main + ConstantUrl.Url_InsertOrdersToCart,
				new Response.Listener<String>() {
					@Override
					public void onResponse(String response) {

						try {

							JSONObject json = new JSONObject(response);
							System.out.println("buy product response" + response);

							String msg = json.getString("message");
							System.out.println("message >>>>>>>>>" + msg);
							
							if (json.getString("code").equals("200")) {
								
								JSONObject jsonDataObj = json.getJSONObject("data");
								
								BuyProductModel buyproductList = new BuyProductModel();
								
								buyproductList.setproduct_bag_id(jsonDataObj.getString("cart_id"));
							
								Singleton.cart_id = jsonDataObj.getString("cart_id");								
								
								buyProductModelList.add(buyproductList);	
								
								Toast.makeText(getActivity().getApplicationContext(),
										"Product successfully added to bag", Toast.LENGTH_SHORT).show();

							}
							
							else 
							{
								Toast.makeText(getActivity().getApplicationContext(),msg, Toast.LENGTH_SHORT).show();
							}

						} catch (JSONException e) {
							// TODO Auto-generated catch block
							e.printStackTrace();
						}

						bpAdapter.notifyDataSetChanged();

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
				params.put("userid", user_id);
				params.put("hotelid", hotel_id);
				params.put("productid", product_id);
				params.put("quantity", product_quantity);
			//	params.put("cost", product_totalAmt);
				
				System.out.println("user_id"+ user_id);
				System.out.println("hotel_id"+ hotel_id);
				System.out.println("product_id"+ product_id);
				System.out.println("product_quantity"+ product_quantity);
			//	System.out.println("product_totalAmt"+ product_totalAmt);
				
				
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

	public void ShowDialog1() {
		
		AlertDialog.Builder alertDialog2 = new AlertDialog.Builder(getActivity());
			
			alertDialog2.setTitle("Please login before you add to bag");
			
			alertDialog2.setPositiveButton("Login",
			    new DialogInterface.OnClickListener() {
			        public void onClick(DialogInterface dialog, int which) {
			            // Write your code here to execute after dialog
			        	
			        	Intent i = new Intent(getActivity(), LoginActivity.class);
						startActivity(i);						
						
						Singleton.previousfragment = "Buy_product";
						Singleton.currentfragment = "";
			          
			        }
			    });

			alertDialog2.setNegativeButton("Skip",
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

}
