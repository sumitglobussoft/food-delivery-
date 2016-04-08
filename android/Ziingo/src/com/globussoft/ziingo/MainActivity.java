 package com.globussoft.ziingo;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

import org.json.JSONArray;
import org.json.JSONObject;

import android.animation.Animator;
import android.animation.AnimatorListenerAdapter;
import android.annotation.TargetApi;
import android.app.AlertDialog;
import android.app.Dialog;
import android.content.ActivityNotFoundException;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.SharedPreferences;
import android.content.res.Configuration;
import android.content.res.TypedArray;
import android.graphics.Point;
import android.graphics.drawable.LayerDrawable;
import android.net.Uri;
import android.os.Build;
import android.os.Bundle;
import android.os.Handler;
import android.support.v4.app.Fragment;
import android.support.v4.app.FragmentManager;
import android.support.v4.app.FragmentTransaction;
import android.support.v4.widget.DrawerLayout;
import android.support.v7.app.ActionBarActivity;
import android.support.v7.app.ActionBarDrawerToggle;
import android.support.v7.widget.Toolbar;
import android.text.Editable;
import android.text.TextWatcher;
import android.util.TypedValue;
import android.view.Display;
import android.view.LayoutInflater;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.ViewAnimationUtils;
import android.view.ViewGroup;
import android.view.Window;
import android.view.WindowManager;
import android.widget.AdapterView;
import android.widget.AdapterView.OnItemClickListener;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;

import com.android.volley.AuthFailureError;
import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.facebook.AccessToken;
import com.globussoft.ziingo.adapter.NavDrawerListAdapter;
import com.globussoft.ziingo.adapter.SearchAdapter;
import com.globussoft.ziingo.fragment.AccountFragment;
//import com.globussoft.ziingo.fragment.Bag_Fragment;
import com.globussoft.ziingo.fragment.FAQsFragment;
import com.globussoft.ziingo.fragment.Filter_Fragment;
import com.globussoft.ziingo.fragment.FoodsFragment;
import com.globussoft.ziingo.fragment.GroceriesFragment;
import com.globussoft.ziingo.fragment.HelpFragment;
import com.globussoft.ziingo.fragment.MenuList;
import com.globussoft.ziingo.fragment.MyOrdersFragment;
import com.globussoft.ziingo.fragment.New_Bag_Fragment;
import com.globussoft.ziingo.fragment.NotificationsFragment;
import com.globussoft.ziingo.fragment.OrderStatusFragment;
import com.globussoft.ziingo.fragment.Product_List;
import com.globussoft.ziingo.fragment.SettingsFragment;
import com.globussoft.ziingo.handler.DatabaseHandler;
import com.globussoft.ziingo.model.NavDrawerItem;
import com.globussoft.ziingo.model.RestaurantListModel;
import com.globussoft.ziingo.ui.MyCallBack;
import com.globussoft.ziingo.utills.ConstantUrl;
import com.globussoft.ziingo.utills.JSONParser;
import com.globussoft.ziingo.utills.Singleton;
import com.globussoft.ziingo.utills.Utils2;

public class MainActivity extends ActionBarActivity implements MyCallBack 
{
	public static int mBagCount , mNotificationsCount = 0;
	private String[] mDrawerTitles;
	private TypedArray mDrawerIcons;
	private ArrayList<NavDrawerItem> drawerItems;
	private DrawerLayout mDrawerLayout;
	private ListView mDrawerList;
	private ActionBarDrawerToggle mDrawerToggle;
	private CharSequence mDrawerTitle;
	public static CharSequence mTitle;
	boolean doubleBackToExitPressedOnce;
	public static FragmentManager mManager;
	boolean loggedIn;
	
	SearchAdapter search_adapter;
	List<RestaurantListModel> rlm = new ArrayList<RestaurantListModel>();

	// SwipeRefreshLayout allows the user to swipe the screen down to trigger a manual refresh
	// private MultiSwipeRefreshLayout mSwipeRefreshLayout;

	public static Context context;
	public static ImageView toolbarback_image, search_btn, interstial_ad_image, close_ads_dialog, srch_cls;
	public static Toolbar toolbar;
	EditText editTextBox;
	public ListView searclist;
	public TextView no_productsl;	
	
	Dialog dialog;
	public JSONParser parser;
	
	DatabaseHandler db;
	
	protected void onCreate(Bundle savedInstanceState) {

		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_main);	
		
		Singleton.userFromMenu = false;
		
		dialog = new Dialog(MainActivity.this);
		parser = new JSONParser();

		dialog.requestWindowFeature(Window.FEATURE_NO_TITLE);
		dialog.getWindow().setLayout(WindowManager.LayoutParams.MATCH_PARENT, WindowManager.LayoutParams.MATCH_PARENT);

		dialog.setContentView(R.layout.dialog_search);
		
		db = new DatabaseHandler(getApplicationContext());

		mManager = getSupportFragmentManager();

		FragmentTransaction ftran = mManager.beginTransaction();
		ftran.replace(R.id.frame_container, new FoodsFragment()).commit();

		toolbar = (Toolbar) findViewById(R.id.toolbar);

		if (toolbar != null)
			setSupportActionBar(toolbar);

		// Singleton.myCallBack = this;

		context = getApplicationContext();

		mDrawerTitles = getResources().getStringArray(R.array.nav_drawer_items);
		mDrawerIcons = getResources().obtainTypedArray(R.array.nav_drawer_icons);
		drawerItems = new ArrayList<NavDrawerItem>();
		mDrawerList = (ListView) findViewById(R.id.list_slidermenu);

		for (int i = 0; i < mDrawerTitles.length; i++) 
		{
			drawerItems.add(new NavDrawerItem(mDrawerTitles[i], mDrawerIcons.getResourceId(i, -(i + 1))));
		}
		
		if(Singleton.user_id == null)
		{
			drawerItems.remove(drawerItems.size()-1);
			drawerItems.add(new NavDrawerItem("Sign In", getResources().obtainTypedArray(R.array.signin_icon)));
		}

		mTitle = mDrawerTitle = getTitle();
		mDrawerLayout = (DrawerLayout) findViewById(R.id.drawer_layout);
		mDrawerToggle = new ActionBarDrawerToggle(this, /* host Activity */
		mDrawerLayout, /* DrawerLayout object */
		toolbar, /* nav drawer icon to replace 'Up' caret */
		R.string.drawer_open, /* "open drawer" description */
		R.string.drawer_close /* "close drawer" description */)

		{
			/** Called when a drawer has settled in a completely closed state. */
			public void onDrawerClosed(View view) {
				super.onDrawerClosed(view);
				getSupportActionBar().setTitle(mTitle);
			}

			/** Called when a drawer has settled in a completely open state. */
			public void onDrawerOpened(View drawerView) {
				super.onDrawerOpened(drawerView);
				getSupportActionBar().setTitle(mDrawerTitle);
			}
		};

		// Set the drawer toggle as the DrawerListener
		mDrawerLayout.setDrawerListener(mDrawerToggle);

		LayoutInflater inflater = getLayoutInflater();

		final ViewGroup header = (ViewGroup) inflater.inflate(R.layout.header,
				mDrawerList, false);

		TextView name_text = (TextView) header.findViewById(R.id.username);

		if (Singleton.user_name != null) 
		{
			name_text.setText(Singleton.user_name);
		}
		
		mDrawerList.addHeaderView(header, null, true); // true = clickable
		
		DrawerLayout.LayoutParams lp = (DrawerLayout.LayoutParams) mDrawerList.getLayoutParams();
		lp.width = calculateDrawerWidth();
		mDrawerList.setLayoutParams(lp);

		mDrawerList.setAdapter(new NavDrawerListAdapter(getApplicationContext(), drawerItems));

		mDrawerList.setOnItemClickListener(new DrawerItemClickListener());

		getSupportActionBar().setDisplayHomeAsUpEnabled(true);

		getSupportActionBar().setHomeButtonEnabled(true);

		if (ConstantUrl.isNetworkAvailable(getApplicationContext())) 
		{	
			if(Singleton.user_id != null && Singleton.hotel_id != null)
			{
				fetchBagCount(Singleton.user_id, Singleton.hotel_id);
			}
		}		
		else
		{
		  Toast.makeText(getApplicationContext(), "Please check your internet connection", Toast.LENGTH_SHORT).show();	
		}

	}

	@Override
	public void onBackPressed() 
	{
		if (Singleton.previousfragment.equals("Product_List")) 
		{
			System.out.println("MenuList >>> Product_List");			

			Singleton.previousfragment = "MenuList";
			Singleton.currentfragment = "Product_List";

			Fragment fragment = new MenuList();
			mManager.beginTransaction().replace(R.id.frame_container, fragment).commit();
			 
			//mManager.popBackStack();
		}
		
		else if (Singleton.previousfragment.equals("Buy_product")) 
		{
			System.out.println("Buy_product >>> Product_List ");
			
			Singleton.previousfragment = "Product_List";
			Singleton.currentfragment = "Buy_product";
			
			Fragment fragment = new Product_List();
			mManager.beginTransaction().replace(R.id.frame_container, fragment).commit();	 

			//	mManager.popBackStack();
		} 

		else if (Singleton.previousfragment.equals("MenuList")) 
		{
			System.out.println("MenuList >>> FoodsFragment ");			

			Singleton.previousfragment = "FoodsFragment";
			Singleton.currentfragment = "MenuList";

			Fragment fragment = new FoodsFragment();
			mManager.beginTransaction().replace(R.id.frame_container, fragment).commit();
			
		//	mManager.popBackStack();
		} 
		else if (Singleton.previousfragment.equals("Bag_Fragment"))
		{
			System.out.println("Bag_Fragment >>> MenuList ");			 

			Singleton.previousfragment = "MenuList";
			Singleton.currentfragment = "Bag_Fragment";
			
			Fragment fragment = new MenuList();
			mManager.beginTransaction().replace(R.id.frame_container, fragment).commit();	
		//	mManager.popBackStack();
		}
		
		else if (Singleton.previousfragment.equals("Profile")) 
		{
			System.out.println("Profile >>> FoodsFragment ");			

			Singleton.previousfragment = "FoodsFragment";
			Singleton.currentfragment = "Profile";

			Fragment fragment = new FoodsFragment();
			mManager.beginTransaction().replace(R.id.frame_container, fragment).commit();			 

			//mManager.popBackStack();
		}
		
		else if (Singleton.previousfragment.equals("MyOrders")) {

			System.out.println("MyOrders >>> FoodsFragment ");		

			Singleton.previousfragment = "FoodsFragment";
			Singleton.currentfragment = "MyOrders";
			
			Fragment fragment = new FoodsFragment();
			mManager.beginTransaction().replace(R.id.frame_container, fragment).commit();			 

			//mManager.popBackStack();
		}
		
		else if (Singleton.previousfragment.equals("Search")) 
		{
			System.out.println("Search >>> FoodsFragment ");
			
			Singleton.previousfragment = "FoodsFragment";
			Singleton.currentfragment = "Search";
			
			Singleton.fromSearch = false;
			Singleton.srch_selected_name = null;
			System.out.println("Singleton.fromSearch >> "+ Singleton.fromSearch);

			Fragment fragment = new FoodsFragment();
			mManager.beginTransaction().replace(R.id.frame_container, fragment).commit();			 

			//mManager.popBackStack();
		}

		else if (Singleton.previousfragment.equals("OrderStatus")) {

			System.out.println("OrderStatus >>> MyOrders ");			

			Singleton.previousfragment = "MyOrders";
			Singleton.currentfragment = "OrderStatus";

			Fragment fragment = new MyOrdersFragment();
			mManager.beginTransaction().replace(R.id.frame_container, fragment).commit();		 

			//mManager.popBackStack();
		}
		
		else if (Singleton.previousfragment.equals("FilterFragment")) 
		{
			System.out.println("FilterFragment >>> FoodsFragment ");			

			Singleton.previousfragment = "FoodsFragment";
			Singleton.currentfragment = "FilterFragment";

			Fragment fragment = new FoodsFragment();
			mManager.beginTransaction().replace(R.id.frame_container, fragment).commit();			 

			//mManager.popBackStack();
		}
		
		else if (Singleton.previousfragment.equals("FoodsFragment")) 
		{
			System.out.println("FoodsFragment >>> ");			

			Singleton.previousfragment = "";
			Singleton.currentfragment = "FoodsFragment";

			/*Fragment fragment = new FoodsFragment();
			mManager.beginTransaction().replace(R.id.frame_container, fragment) .commit();*/
			
			finish();

			//mManager.popBackStack();
		}

		// if (mManager.getBackStackEntryCount() <1)

		// else if(Singleton.previousfragment.isEmpty())

		else if (mManager.getBackStackEntryCount() < 1) {
			if (doubleBackToExitPressedOnce) {
				super.onBackPressed();

				return;
			}
			this.doubleBackToExitPressedOnce = true;

			// CommonMethods.showMyToast(MainActivity.this, "Please click BACK again to exit");
			Toast.makeText(getApplicationContext(), "Please click BACK again to exit", Toast.LENGTH_SHORT).show();
			
			new Handler().postDelayed(new Runnable() 
			{
				@Override
				public void run() 
				{
					doubleBackToExitPressedOnce = false;
				}
			}, 2000);
		} 
		else if (mManager.getBackStackEntryCount() >= 1) 
		{
			mManager.popBackStack();
		}
	}

	@Override
	protected void onPostCreate(Bundle savedInstanceState) {
		super.onPostCreate(savedInstanceState);
		// Sync the toggle state after onRestoreInstanceState has occurred.
		mDrawerToggle.syncState();
	}

	@Override
	public void onConfigurationChanged(Configuration newConfig) {
		super.onConfigurationChanged(newConfig);
		mDrawerToggle.onConfigurationChanged(newConfig);
	}

	/* Called whenever we call invalidateOptionsMenu() */
	@Override
	public boolean onPrepareOptionsMenu(Menu menu) {
		// If the nav drawer is open, hide action items related to the content view
		System.out.println("onPrepareOptionsMenu ");
		boolean drawerOpen = mDrawerLayout.isDrawerOpen(mDrawerList);
		menu.findItem(R.id.action_search).setVisible(!drawerOpen);
		return super.onPrepareOptionsMenu(menu);

	}

	/**
	 * Swaps fragments in the main content view
	 */
	private void selectItem(int position) {

		Fragment fragment = null;

		switch (position) {

		case 0:
			// Header
			System.out.println("Clicked on header");
			break;

		case 1:
			// Restaurant details
			System.out.println("Clicked on Foods");
			fragment = new FoodsFragment();
			break;

		case 2:
			// Groceries
			System.out.println("Clicked on Groceries");
			fragment = new GroceriesFragment();
			break;

		case 3:
			// MyOrders
			System.out.println("Clicked on  MyOrders");
			fragment = new MyOrdersFragment();
			break;
		
		case 4:
			// Account
			System.out.println("Clicked on  Account");
			fragment = new AccountFragment();
			break;

		case 5:
			// RateUs
			System.out.println("Clicked on RateUs");
			//fragment = new RateUsFragment();
			 launchMarket() ;
			
			break;

		case 6:
			// FAQs
			System.out.println("Clicked on FAQs");
			fragment = new FAQsFragment();
			break;

		case 7:
			// Settings
			System.out.println("Clicked on Settings");
			fragment = new SettingsFragment();
			break;

		case 8:
			// Help
			System.out.println("Clicked on Help");
			fragment = new HelpFragment();
			break;

		case 9:
			// SignOut
			System.out.println("Clicked on SignOut");
			
			System.out.println("mDrawerTitle >>> "+ drawerItems.get(position-1).getTitle().toString());
			
			//fragment = new SignOutFragment();
			
			//just clear all stored data
	
			/*loggedIn = isFacebookLoggedIn();
			
			if(loggedIn)
			{
			LoginManager.getInstance().logOut();
			}*/
			
			if(drawerItems.get(position-1).getTitle().toString().equalsIgnoreCase("Sign Out"))
			{	
				showSignOut_Dialog();			
			}
			
			else if(drawerItems.get(position-1).getTitle().toString().equalsIgnoreCase("Sign In"))
			{
				Intent i = new Intent(MainActivity.this, LoginActivity.class);
				startActivity(i);
				
				Singleton.fromSign = true;
			}
			
			break;

		default:
			fragment = new FoodsFragment();
			break;

		}

		if (fragment != null) {
			// Insert the fragment by replacing any existing fragment
			mManager.beginTransaction().replace(R.id.frame_container, fragment).commit();
			// swipeFragment(fragment);
		}

		// Highlight the selected item, update the title, and close the drawer
		mDrawerList.setItemChecked(position, true);

		if (position != 0) {
			setTitle(mDrawerTitles[position - 1]);
		}

		mDrawerLayout.closeDrawer(mDrawerList);

	}
	
	private void launchMarket() 
	{
	    Uri uri = Uri.parse("market://details?id=" + "com.cubeactive.qnotelistfree");
	    Intent myAppLinkToMarket = new Intent(Intent.ACTION_VIEW, uri);	    
	   
	    try 
	    {
	        startActivity(myAppLinkToMarket);
	    } 
	    catch (ActivityNotFoundException e) 
	    {
	       // Toast.makeText(this, " Sorry, Unable to open!", Toast.LENGTH_SHORT).show();
	      startActivity(new Intent(Intent.ACTION_VIEW, Uri.parse("http://play.google.com/store/apps/details?id=" 
	    		  	+ "com.cubeactive.qnotelistfree")));
	    }
		
	}
	
	private void showSignOut_Dialog()
	{		// TODO Auto-generated method stub

		AlertDialog.Builder alertDialog1 = new AlertDialog.Builder(MainActivity.this);

		alertDialog1.setTitle("Do you really want to Sign Out?");

		alertDialog1.setPositiveButton("Yes", new DialogInterface.OnClickListener() 
		{
			public void onClick(DialogInterface dialog, int which)
			{
				SharedPreferences preferences = context.getSharedPreferences("Ziingo", MODE_PRIVATE);
				SharedPreferences.Editor editor = preferences.edit();
				//editor.remove("user_id").commit();
				editor.clear();
				editor.commit();
				finish(); 		                        
		            
				Singleton.user_name = null;
				Singleton.user_id = null;
				Singleton.delivery_charge = null;
				mBagCount = 0;
				New_Bag_Fragment.bagModelList.clear();
				db.deleteAll();
		            
				System.out.println("Clear DB >> " +db.getProductsCount());					
				System.out.println("Sign_Out >>>>>> Singleton.user_id >>"+Singleton.user_id);
				System.out.println("Sign_Out >>>>>> Singleton.delivery_charge >>"+Singleton.delivery_charge);		            
				System.out.println("************"); 
		            
				Intent i = new Intent(MainActivity.this, LoginActivity.class);
				startActivity(i);
						

			}
		});

		alertDialog1.setNegativeButton("No", new DialogInterface.OnClickListener() 
		{
			public void onClick(DialogInterface dialog, int which) 
			{
				// Write your code here to execute after dialog
			    dialog.cancel();
		    }
		});

		// Showing Alert Dialog
		Dialog alertDialog = alertDialog1.create();
		alertDialog.setCanceledOnTouchOutside(false);
		alertDialog1.show();	
		
	}

	private boolean isFacebookLoggedIn() {
		// TODO Auto-generated method stub
		return AccessToken.getCurrentAccessToken() != null;
	}

	public void setTitle(CharSequence title) {
		mTitle = title;
		getSupportActionBar().setTitle(mTitle);
		System.out.println("setTitle");
	}

	@Override
	public boolean onCreateOptionsMenu(Menu menu) {

		getMenuInflater().inflate(R.menu.main, menu);

		// Get the notifications MenuItem and LayerDrawable (layer-list)

		if (Build.VERSION.SDK_INT >= 16) 
		{
			MenuItem item = menu.findItem(R.id.action_bag);
			LayerDrawable icon = (LayerDrawable) item.getIcon();

			// Update LayerDrawable's BadgeDrawable
			Utils2.setBadgeCount(this, icon, mBagCount);
		}

		/*
		 * if (menu.getItem(3).getItemId() == R.id.action_settings) { if
		 * (Singleton.user_id.equals("")) menu.getItem(3).setTitle("Login"); }
		 */

		System.out.println("Oncreate option menu");

		return super.onCreateOptionsMenu(menu);

		// return true;
	}

	@Override
	public boolean onOptionsItemSelected(MenuItem item) {
		System.out.println(" onOptionsItemSelected");

		// Handle action bar item clicks here. The action bar will
		// automatically handle clicks on the Home/Up button, so long
		// as you specify a parent activity in AndroidManifest.xml.
		switch (item.getItemId()) {
		// Respond to the action bar's Up/Home button
		case android.R.id.home:

			mDrawerToggle.setDrawerIndicatorEnabled(true);

			return true;
		}

		if (item.getItemId() == R.id.action_notification) 
		{
			// Notification Fragment
			Fragment fragment = new NotificationsFragment();
			mManager.beginTransaction().replace(R.id.frame_container, fragment).commit();

			setTitle("Notifications");
		}

		else if (item.getItemId() == R.id.action_bag) {

			System.out.println(" Bag clicked");

			// Bag Fragment
			
			if(Singleton.user_id != null)
			{
				fetchBagCount(Singleton.user_id, Singleton.hotel_id);
			
				New_Bag_Fragment.bagModelList.clear();
				//Singleton.productCartid_List.clear();
			}
			
			Fragment fragment = new New_Bag_Fragment();
			mManager.beginTransaction().replace(R.id.frame_container, fragment).commit();

			setTitle("Bag");
		}

		else if (item.getItemId() == R.id.action_filter) {

			System.out.println(" Filter clicked");

			// Filter Fragment

			Fragment fragment = new Filter_Fragment();
			mManager.beginTransaction().replace(R.id.frame_container, fragment).commit();

			setTitle("Filter");
		}

		else if (item.getItemId() == R.id.action_search) {
			rlm.clear();
			OpenLocationChnageDialog();

			setTitle("Search");
		}

		return super.onOptionsItemSelected(item);
	}

	public int calculateDrawerWidth() {
		// Calculate ActionBar height
		TypedValue tv = new TypedValue();
		int actionBarHeight = 0;
		if (getTheme().resolveAttribute(android.R.attr.actionBarSize, tv, true)) 
		{
			actionBarHeight = TypedValue.complexToDimensionPixelSize(tv.data,
					getResources().getDisplayMetrics());
		}

		Display display = getWindowManager().getDefaultDisplay();
		int width;
		int height;
		if (android.os.Build.VERSION.SDK_INT >= 13) 
		{
			Point size = new Point();
			display.getSize(size);
			width = size.x;
			height = size.y;
		} 
		else 
		{
			width = display.getWidth(); // deprecated
			height = display.getHeight(); // deprecated
		}
		return width - actionBarHeight;
	}

	private class DrawerItemClickListener implements ListView.OnItemClickListener 
	{
		@Override
		public void onItemClick(AdapterView<?> parent, View view, int position,	long id) 
		{
			System.out.println("DrawerItemClickListener ");
			selectItem(position);
		}
	}

	@TargetApi(Build.VERSION_CODES.LOLLIPOP)
	public void circleIn(View view) {

		// get the center for the clipping circle
		int cx = (view.getLeft() + view.getRight()) / 2;
		int cy = (view.getTop() + view.getBottom()) / 2;

		// get the final radius for the clipping circle
		int finalRadius = Math.max(view.getWidth(), view.getHeight());

		// create the animator for this view (the start radius is zero)
		Animator anim = ViewAnimationUtils.createCircularReveal(view, cx, cy,
				0, finalRadius);

		// make the view visible and start the animation
		view.setVisibility(View.VISIBLE);
		anim.start();
	}

	@TargetApi(Build.VERSION_CODES.LOLLIPOP)
	public void circleOut(final View view) {

		// get the center for the clipping circle
		int cx = (view.getLeft() + view.getRight()) / 2;
		int cy = (view.getTop() + view.getBottom()) / 2;

		// get the initial radius for the clipping circle
		int initialRadius = view.getWidth();

		// create the animation (the final radius is zero)
		Animator anim = ViewAnimationUtils.createCircularReveal(view, cx, cy,
				initialRadius, 0);

		// make the view invisible when the animation is done
		anim.addListener(new AnimatorListenerAdapter() {
			@Override
			public void onAnimationEnd(Animator animation) {
				super.onAnimationEnd(animation);
				view.setVisibility(View.INVISIBLE);
			}
		});

		// start the animation
		anim.start();
	}

	public static void MakeToast(String message) 
	{
		Toast.makeText(context, message, Toast.LENGTH_LONG).show();
	}

	public static void swipeFragment(Fragment fragment) 
	{
		mManager.beginTransaction().replace(R.id.frame_container, fragment).addToBackStack(null).commit();
	}

	static Handler handler = new Handler();

	public void executeThis() 
	{
		handler.post(new Runnable() 
		{
			@Override
			public void run()
			{
				mDrawerToggle.setDrawerIndicatorEnabled(false);
			}
		});
	}

	public void updateNotificationsBadge(int count) 
	{		// mNotificationsCount = count;

		mBagCount = count;
		// force the ActionBar to relayout its MenuItems.
		// onCreateOptionsMenu(Menu) will be called again.
		 invalidateOptionsMenu();
	}
	

	public void fetchBagCount(final String user_id, final String hotel_id)
	{		
		System.out.println("hotel_id >>>>>>> " + Singleton.hotel_id);
		System.out.println("delivery_charge >>>>>>> " + Singleton.delivery_charge);
		
		// Singleton.product_cartid.clear();
		// Singleton.productCartid_List.clear();
		// New_Bag_Fragment.bagModelList.clear();
		// New_Bag_Fragment.bagModelList = db.getAllAddedProducts();

		RequestQueue queue = Volley.newRequestQueue(getApplicationContext());
		StringRequest sr = new StringRequest(Request.Method.POST,
				ConstantUrl.Url_main + ConstantUrl.Url_GetOrdersToCart,
				new Response.Listener<String>() {
					@Override
					public void onResponse(String response) {

						try {
							JSONObject json = new JSONObject(response);

							System.out.println("bag details response" + response);

							String msg = json.getString("message");
							System.out.println("message >>>>>>>>>" + msg);

							if (json.getString("code").equals("200")) {
								
								JSONObject jsonobj = json.getJSONObject("data");
								Singleton.cart_subtotal_amt = jsonobj.getString("subtotal");

								JSONArray jsonMainArr = jsonobj	.getJSONArray("products");
								
								/*if(jsonMainArr.length()!=0)
								{
									updateNotificationsBadge(jsonMainArr.length());
								}*/									
							}

							else 
							{
								Toast.makeText(getApplication(),msg, Toast.LENGTH_SHORT).show();	
							}

						} 
						catch (Exception e) 
						{
							e.printStackTrace();
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

	public void OpenLocationChnageDialog() {

		editTextBox  = (EditText) dialog.findViewById(R.id.editbox);
		searclist    = (ListView) dialog.findViewById(R.id.list);
		search_btn   = (ImageView) dialog.findViewById(R.id.search_btn);
		no_productsl = (TextView) dialog.findViewById(R.id.no_products);
		srch_cls = (ImageView) dialog.findViewById(R.id.sr_cls);

		//search_adapter = new SearchAdapter(getApplicationContext(), rlm);
		
		search_adapter = new SearchAdapter(getApplicationContext(), rlm);
		searclist.setAdapter(search_adapter);

		// enables filtering for the contents of the given ListView
		searclist.setTextFilterEnabled(true);

		searclist.setOnItemClickListener(new OnItemClickListener() {

			@Override
			public void onItemClick(AdapterView<?> parent, View view,
					int position, long id) {

				Singleton.srch_selected_name = rlm.get(position).getRest_name();

				System.out.println("Singleton.srch_selected_name == " + Singleton.srch_selected_name);				

				// Singleton.previousfragment = "Product_List";
				// Singleton.currentfragment = "SelectedProductDetails";
				
				Singleton.previousfragment = "Search";
				Singleton.currentfragment = "FoodsFragment";
				
				Singleton.fromSearch = true;
				System.out.println("Singleton.fromSearch >> "+ Singleton.fromSearch);
				
				Fragment fragment = new FoodsFragment();
				mManager.beginTransaction().replace(R.id.frame_container, fragment).commit();
				dialog.dismiss();

			}
		});

		editTextBox.addTextChangedListener(new TextWatcher() {

			public void afterTextChanged(Editable s) {
			}

			public void beforeTextChanged(CharSequence s, int start, int count,
					int after) {
			}

			public void onTextChanged(CharSequence s, int start, int before,
					int count) {
				 search_adapter.getFilter().filter(s.toString());				
			}
		});

		search_btn.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View v) {

				// rlm.clear();
				// search_adapter.notifyDataSetChanged();

				if (!editTextBox.getText().toString().trim().isEmpty()) 
				{
					searchRestName();
				} 
				else 
				{
					editTextBox.setError("please enter restaurant name");
				}

			}
		});
		
		srch_cls.setOnClickListener(new OnClickListener() {
			
			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub
				
				dialog.dismiss();
				
			}
		});

		if (ConstantUrl.isNetworkAvailable(getApplicationContext())) 
		{
			searchRestName();

		} 
		else 
		{
			Toast.makeText(getApplicationContext(), "Please check internet connection!!", Toast.LENGTH_SHORT).show();
		}

		dialog.show();		

	}

	public void searchRestName()
	{

		rlm.clear();

		for (int i = 0; i < Singleton.LocRestNameList.size(); i++) 
		{
			RestaurantListModel restListModel = new RestaurantListModel();

			restListModel.setRest_name(Singleton.LocRestNameList.get(i));
			rlm.add(restListModel);

		}

		search_adapter.notifyDataSetChanged();
	}

	@Override
	protected void onResume() {
		// TODO Auto-generated method stub
		super.onResume();
		invalidateOptionsMenu();
		System.out.println("************************Singleton.isNeedToShowOrderDetails******************* = "+Singleton.isNeedToShowOrderDetails);
		if (Singleton.isNeedToShowOrderDetails) {
			
			Singleton.isNeedToShowOrderDetails = false;
			
			OrderStatusFragment fragmentOS = new OrderStatusFragment();

			MainActivity.mManager.beginTransaction().replace(R.id.frame_container, fragmentOS).commit();

		}
	}

}