package com.globussoft.ziingo.adapter;

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
import com.android.volley.toolbox.ImageLoader;
import com.android.volley.toolbox.NetworkImageView;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.globussoft.ziingo.MainActivity;
import com.globussoft.ziingo.R;
import com.globussoft.ziingo.api.AppController;
import com.globussoft.ziingo.fragment.New_Bag_Fragment;
import com.globussoft.ziingo.handler.DatabaseHandler;
import com.globussoft.ziingo.model.BagModel;
import com.globussoft.ziingo.utills.ConstantUrl;
import com.globussoft.ziingo.utills.Singleton;

import android.app.AlertDialog;
import android.content.Context;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.view.View.OnClickListener;
import android.widget.BaseAdapter;
import android.widget.ImageView;
import android.widget.TextView;
import android.widget.Toast;

public class New_BagAdapter extends BaseAdapter {

	List<BagModel> bagListItems = new ArrayList<BagModel>();

	AlertDialog.Builder alert;
	private Context context;
	View view;

	ImageLoader imageLoader = AppController.getInstance().getImageLoader();

	DatabaseHandler db;

	public New_BagAdapter(Context context, List<BagModel> bagListItems) {

		System.out.println("context" + context);
		this.context = context;
		this.bagListItems = bagListItems;

	}

	@Override
	public int getCount() {
		// TODO Auto-generated method stub
		return bagListItems.size();
	}

	@Override
	public Object getItem(int location) {
		// TODO Auto-generated method stub
		return bagListItems.get(location);
	}

	@Override
	public long getItemId(int position) {
		// TODO Auto-generated method stub
		return position;
	}

	@Override
	public View getView(final int position, View convertView, ViewGroup parent) {
		// TODO Auto-generated method stub

		db = new DatabaseHandler(context);

		LayoutInflater inflater = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);

		if (convertView == null)
			convertView = inflater.inflate(R.layout.bag_list, null);

		TextView Bag_product_name = (TextView) convertView.findViewById(R.id.product_name_txt);
		TextView Bag_product_price = (TextView) convertView.findViewById(R.id.pr_price);
		TextView Bag_Product_qnt = (TextView) convertView.findViewById(R.id.product_qnty);
		final ImageView Product_rmv = (ImageView) convertView.findViewById(R.id.pr_rmv);
		NetworkImageView Product_image = (NetworkImageView) convertView.findViewById(R.id.thumbnail);

		BagModel m = bagListItems.get(position);

		Bag_product_name.setText(m.getBag_product_name());
		Bag_product_price.setText(Singleton.currency + m.getBag_product_price());
		Bag_Product_qnt.setText(m.getBag_product_qnt());
		Product_image.setImageUrl(m.getBag_product_image(), imageLoader);

		Product_rmv.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub

				Singleton.product_cart_id = bagListItems.get(position).getBag_product_cartid();
				Singleton.cart_product_amt = bagListItems.get(position).getBag_product_price();
				
				System.out.println("product_cart_id to be REMOVED ==== "+ Singleton.product_cart_id);

				if (!Singleton.productCartid_List.isEmpty()) 
				{
					if (Singleton.productid_cartlist.contains(bagListItems.get(position).getproduct_id()));

					{
						System.out.println("Singleton.user_id === "+ Singleton.user_id);
						System.out.println("Singleton.cart_product_amt === "+ Singleton.cart_product_amt);
						System.out.println("Singleton.cart_subtotal_amt === "+ Singleton.cart_subtotal_amt);

						Singleton.product_total_list.remove(Singleton.cart_product_amt);
						Singleton.productCartid_List.remove(Singleton.product_cart_id); // removed from list

						System.out.println(" Singleton.product_cartid == "+ Singleton.productCartid_List);

						//bagListItems.remove(position);

						System.out.println("Remaining Singleton.product_cartid == "+ Singleton.productCartid_List); // list

						DelfromBag(Singleton.user_id, Singleton.product_cart_id);
					}
				}
				
				Singleton.product_id_list.remove(bagListItems.get(position).getproduct_id());
				Singleton.product_qnty_list.remove(bagListItems.get(position).getBag_product_qnt());
				Singleton.product_total_list.remove(Singleton.cart_product_amt);
				
				int amt = 0;
				for (int i = 0; i < Singleton.product_total_list.size(); i++) 
				{
					amt += Integer.parseInt(Singleton.product_total_list.get(i));
				}

				Singleton.cart_subtotal_amt = String.valueOf(amt);

				/*for (int i = 0; i < Singleton.product_total_list.size(); i++) 
				{
					New_Bag_Fragment.cart_ttl_amt += Integer.parseInt(Singleton.product_total_list.get(i));
				}

				Singleton.cart_subtotal_amt = String.valueOf(New_Bag_Fragment.cart_ttl_amt);*/

				
				// Deleting product
				Log.d("Delete: ", "Deleting ..");
				db.deleteProduct(bagListItems.get(position).getproduct_id());

				// Reading all products
				Log.d("Reading: ", "Reading all products..");
				New_Bag_Fragment.bagModelList = db.getAllAddedProducts();

				for (BagModel bm : New_Bag_Fragment.bagModelList) {
					String log = "Product_Id: " + bm.getproduct_id()
							+ " ,Product_Name: " + bm.getBag_product_name()
							+ " ,Product_quantity: " + bm.getBag_product_qnt()
							+ " ,Product_totalAmt: "+ bm.getBag_product_price() 
							+ " ,Product_image: "+ bm.getBag_product_image()
							+ " ,Product_cart_id: "+ bm.getBag_product_cartid();

					// Writing Products to log
					Log.d("Name: ", log);

				}

				/*Singleton.product_id_list.remove(bagListItems.get(position).getproduct_id());
				Singleton.product_qnty_list.remove(bagListItems.get(position).getBag_product_qnt());*/
				/*Singleton.product_total_list.remove(bagListItems.get(position).getBag_product_price());*/

				bagListItems.remove(position);
				
				/*int amt = 0;
				for (int i = 0; i < Singleton.product_total_list.size(); i++) {
					amt += Integer.parseInt(Singleton.product_total_list.get(i));
				}

				Singleton.cart_subtotal_amt = String.valueOf(amt);*/

				/*
				 * Singleton.cart_subtotal_amt =
				 * String.valueOf(((Integer.parseInt
				 * (Singleton.cart_subtotal_amt))-
				 * (Integer.parseInt(Singleton.cart_product_amt))));
				 */

				Singleton.cart_total_amt = String.valueOf(((Integer.parseInt(Singleton.cart_subtotal_amt)) 
						+ (Integer.parseInt(Singleton.delivery_charge))));

				New_Bag_Fragment.sub_total.setText(Singleton.currency + " "+ Singleton.cart_subtotal_amt);
				New_Bag_Fragment.bag_total.setText(Singleton.currency + " "+ Singleton.cart_total_amt);

				if ((Integer.parseInt(Singleton.cart_total_amt)) >= (Integer.parseInt(Singleton.min_order))) 
				{
					New_Bag_Fragment.min_order_amt.setVisibility(View.GONE);
				} 
				else 
				{
					New_Bag_Fragment.min_order_amt.setVisibility(View.VISIBLE);
				}

				if (getCount() == 0) {
					New_Bag_Fragment.no_bag_items.setVisibility(View.VISIBLE);
					New_Bag_Fragment.sub_total.setText(Singleton.currency+ " 0");
					New_Bag_Fragment.bag_total.setText(Singleton.currency+ " 0");
					New_Bag_Fragment.del_chrg.setText(Singleton.currency + " 0");
				}

				notifyDataSetChanged();

			}
		});

		return convertView;
	}

	public void DelfromBag(final String user_id, final String product_cart_id) 
	{

		RequestQueue queue = Volley.newRequestQueue(context);
		StringRequest sr = new StringRequest(Request.Method.POST,
				ConstantUrl.Url_main + ConstantUrl.Url_RemoveOrderToCart,
				new Response.Listener<String>() {
					@Override
					public void onResponse(String response) {

						try {

							JSONObject json = new JSONObject(response);
							System.out.println("Delete from Bag" + response);

							String msg = json.getString("message");
							System.out.println("message >>>>>>>>>" + msg);

							if (json.getString("code").equals("200")) {

								JSONObject jsonobj = json.getJSONObject("data");

								Singleton.cart_hotel_name = jsonobj.getString("hotel_name");
								Singleton.cart_hotel_id = jsonobj.getString("hotel_id");
								Singleton.delivery_charge = jsonobj.getString("deliverycharge");
								Singleton.cart_subtotal_amt = jsonobj.getString("subtotal");

								JSONArray jsonMainArr = jsonobj.getJSONArray("products");

								//MainActivity.mBagCount = jsonMainArr.length();
								 

								for (int j = 0; j < jsonMainArr.length(); j++) {

									BagModel bagModel = new BagModel();

									JSONObject childJSONObject = jsonMainArr.getJSONObject(j);

									bagModel.setBag_product_cartid(childJSONObject.getString("cart_id"));

									Singleton.product_cart_id = childJSONObject.getString("cart_id");

									Singleton.productCartid_List.add(Singleton.product_cart_id);

									/*
									 * bagModel.sethotel_id(childJSONObject.getString("hotel_id"));
									 */
									bagModel.setBag_product_name(childJSONObject.getString("product_name"));
									bagModel.setBag_product_qnt(childJSONObject.getString("quantity"));
									bagModel.setBag_product_price(childJSONObject.getString("sub_cost_product"));
									bagModel.setproduct_id(childJSONObject.getString("product_id"));
									bagModel.setBag_product_image(childJSONObject.getString("imagelink"));

									//bagListItems.add(bagModel);

								}

								//System.out.println("Removed from Bag mBagCount > " + MainActivity.mBagCount);
								Toast.makeText(context.getApplicationContext(), "Product successfully deleted from bag",
										Toast.LENGTH_SHORT).show();
							} 
							else 
							{
								Toast.makeText(context.getApplicationContext(), msg, Toast.LENGTH_SHORT).show();
							}

						} catch (JSONException e) {
							// TODO Auto-generated catch block
							e.printStackTrace();
						}
						
					//	MainActivity.mBagCount = bagListItems.size();

						notifyDataSetChanged();

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
				params.put("user_id", user_id);
				params.put("cart_id", product_cart_id);

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
