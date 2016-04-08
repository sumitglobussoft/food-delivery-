package com.globussoft.ziingo;

import java.util.Collections;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import com.android.volley.AuthFailureError;
import com.android.volley.NetworkResponse;
import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.globussoft.ziingo.fragment.New_Bag_Fragment;
import com.globussoft.ziingo.model.BagModel;
import com.globussoft.ziingo.utills.ConstantUrl;
import com.globussoft.ziingo.utills.Singleton;

import android.app.Activity;
import android.content.Intent;
import android.content.SharedPreferences;
import android.content.SharedPreferences.Editor;
import android.os.Bundle;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.ImageView;
import android.widget.RelativeLayout;
import android.widget.TextView;
import android.widget.Toast;

public class Edit_Add_deliverAddress extends Activity{
	
	TextView del_name, del_address, del_loc, delcitypin, delstate, delmobile;
	RelativeLayout edit_address, add_address;
	ImageView delplace_or, bk_btn;
	
	SharedPreferences pref;
	Editor editor;
	int PRIVATE_MODE = 0;
	
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		// TODO Auto-generated method stub
		super.onCreate(savedInstanceState);
	setContentView(R.layout.edit_delivery_address);
	InitUI();
	}
	
	protected void sharedPrefernces() {
		pref = getSharedPreferences("Ziingo", MODE_PRIVATE);
		editor = pref.edit();

		editor.putString("delivery_fn", Singleton.delFullname);		
		editor.putString("delivery_ph", Singleton.delPh_num);
		editor.putString("delivery_address", Singleton.delAddress);
		editor.putString("delivery_landmark", Singleton.delLandMark);
		editor.putString("delivery_pincode", Singleton.delpincode);
		editor.putString("order_id", Singleton.order_id);
		//editor.putString("delivery_id", Singleton.delivery_id);

		editor.commit();

	}
	
	private void InitUI()
	{
		del_name     = (TextView) findViewById(R.id.delname);
		del_address  = (TextView) findViewById(R.id.deladdress);
		del_loc		 = (TextView) findViewById(R.id.delloc);	
		delcitypin   = (TextView) findViewById(R.id.delcitypin);
		delstate 	 = (TextView) findViewById(R.id.delstate);
		delmobile 	 = (TextView) findViewById(R.id.delmobile);
		
		delplace_or  = (ImageView) findViewById(R.id.delplaceor);
		bk_btn 		 = (ImageView) findViewById(R.id.bkbtn11);
		edit_address = (RelativeLayout) findViewById(R.id.bbbb);
		add_address  = (RelativeLayout) findViewById(R.id.cccc);
		
		del_name.setText(Singleton.delFullname);
		del_address.setText(Singleton.delAddress);
		del_loc.setText(Singleton.delLoc);
		delcitypin.setText(Singleton.delCity+ " - "+Singleton.delpincode);
		delstate.setText(Singleton.Spn_StateName);
		delmobile.setText("Mobile: "+Singleton.delPh_num);
		
		bk_btn.setOnClickListener(new OnClickListener() {
			
			@Override
			public void onClick(View v) 
			{
				// TODO Auto-generated method stub
				onBackPressed();
			}
		});
		
		
		edit_address.setOnClickListener(new OnClickListener() {
			
			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub
				
				Intent i = new Intent(Edit_Add_deliverAddress.this, Edit_saved_DeliveryAddress.class);
				startActivity(i);
				
			}
		});
		
		add_address.setOnClickListener(new OnClickListener() {
			
			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub
				
				Singleton.add_new_DelAddress = true;
				
				if(New_Bag_Fragment.save_del_add_count < 3)
				{
				   Intent i = new Intent(Edit_Add_deliverAddress.this, DeliveryAddress_Activity.class);
				   startActivity(i);
				
				   finish();
				}
				else
				{
					Toast.makeText(getApplicationContext(), 
							"Cannot add more than 3 addresses. Please edit or change previously saved address.", 
							Toast.LENGTH_SHORT).show();
				}
				
			}
		});
		
		delplace_or.setOnClickListener(new OnClickListener() {
			
			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub
				
				insertOr_DelAdd(Singleton.del_address_ID,
						Singleton.cart_subtotal_amt,
						Singleton.delivery_charge,
						Singleton.productCartid_List, 
						Singleton.product_total_list);
				
			}
		});
		
	}
	
	private void insertOr_DelAdd(final String del_address_ID, final String cart_subtotal_amt,
			final String delivery_charge,
			final List<String> productCartid_List, 
			final List<String> product_total_list)
	{

		System.out.println("del_address_ID = " + del_address_ID);
		System.out.println("cart_subtotal_amt = " + cart_subtotal_amt);
		System.out.println("delivery_charge = " + delivery_charge);
		System.out.println("productCartid_List = " + productCartid_List);
		System.out.println("product_total_list = " + product_total_list);

		RequestQueue queue = Volley.newRequestQueue(getApplicationContext());
		StringRequest sr = new StringRequest(Request.Method.POST,
				ConstantUrl.Url_main + ConstantUrl.Url_insertorders,
				new Response.Listener<String>() {
					@Override
					public void onResponse(String response) {

						try {

							System.out.println(">>>>>>>>>>>>>");

							JSONObject json = new JSONObject(response);

							System.out.println("Insert Order REsponse:  " + response);

							String msg = json.getString("message");

							System.out.println("message >>>>>>>>>" + msg);

							if (json.getInt("code")== 200) 
							{
								JSONObject data = json.getJSONObject("data");

								Singleton.order_id = data.getString("order_id");

								System.out.println("Singleton.order_id : "+Singleton.order_id);

								//Toast.makeText(getApplicationContext(),"order placed SUCCESSFULLY", Toast.LENGTH_SHORT).show();

								sharedPrefernces();
								
								Intent i = new Intent(getApplicationContext(), PaymentActivity.class);
								startActivity(i);
								
								finish();

							}

							else 
							{
								Toast.makeText(getApplicationContext(), msg, Toast.LENGTH_SHORT).show();
							}

						} catch (JSONException e) {
							// TODO Auto-generated catch block
							e.printStackTrace();
						}


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
			protected Map<String, String> getParams() 
			{

				Map<String, String> params = new HashMap<String, String>();

				JSONArray a = new JSONArray();
				JSONArray b = new JSONArray();

				for (int i = 0; i < productCartid_List.size(); i++) 
				{
					a.put(productCartid_List.get(i));
				}
				
				for (int i = 0; i < product_total_list.size(); i++) 
				{
					b.put(product_total_list.get(i));
				}

				params.put("cartid", a.toString());
				params.put("addressid", del_address_ID);
				params.put("totalamount", cart_subtotal_amt);
				params.put("deliverycharge", delivery_charge);
				params.put("productamount", b.toString());
				
				return params;
			}

			@Override
			public Map<String, String> getHeaders() throws AuthFailureError 
			{
				Map<String, String> params = new HashMap<String, String>();
				params.put("Content-Type", "application/x-www-form-urlencoded");
				return params;
			}
			
			 @Override
			 protected Response<String> parseNetworkResponse(NetworkResponse response) {
			         if (response.headers == null)
			         {
			             // cant just set a new empty map because the member is final.
			             response = new NetworkResponse(
			                                response.statusCode,
			                                response.data,
			                                Collections.<String, String>emptyMap(), // this is the important line, set an empty but non-null map.
			                                response.notModified);


			         }

			         return super.parseNetworkResponse(response);
			     }
		};

		queue.add(sr);

	}

}
