package com.globussoft.ziingo;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;
import java.util.Timer;

import org.apache.http.NameValuePair;
import org.apache.http.message.BasicNameValuePair;
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import android.animation.Animator;
import android.animation.AnimatorListenerAdapter;
import android.annotation.TargetApi;
import android.app.Dialog;
import android.content.Context;
import android.content.Intent;
import android.content.res.Configuration;
import android.content.res.TypedArray;
import android.graphics.Point;
import android.graphics.drawable.LayerDrawable;
import android.os.AsyncTask;
import android.os.Build;
import android.os.Bundle;
import android.os.Handler;
import android.support.v4.app.Fragment;
import android.support.v4.app.FragmentActivity;
import android.support.v4.app.FragmentManager;
import android.support.v4.app.FragmentManager.OnBackStackChangedListener;
import android.support.v4.app.FragmentTransaction;
import android.support.v4.view.ViewPager;
import android.support.v4.widget.DrawerLayout;
import android.support.v4.widget.SwipeRefreshLayout;
import android.support.v7.app.ActionBarActivity;
import android.support.v7.app.ActionBarDrawerToggle;
import android.support.v7.widget.Toolbar;
import android.text.Editable;
import android.text.TextWatcher;
import android.util.Log;
import android.util.TypedValue;
import android.view.Display;
import android.view.LayoutInflater;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.view.ViewAnimationUtils;
import android.view.ViewGroup;
import android.view.Window;
import android.view.WindowManager;
import android.view.View.OnClickListener;
import android.widget.AdapterView;
import android.widget.EditText;
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
import com.globussoft.ziingo.R;
import com.globussoft.ziingo.Interface.OnBackPressedListener;
import com.globussoft.ziingo.adapter.NavDrawerListAdapter;
import com.globussoft.ziingo.adapter.SearchAdapter;
import com.globussoft.ziingo.fragment.AccountFragment;
import com.globussoft.ziingo.fragment.Bag_Fragment;
import com.globussoft.ziingo.fragment.BookmarksFragment;
import com.globussoft.ziingo.fragment.Buy_product;
import com.globussoft.ziingo.fragment.FAQsFragment;
import com.globussoft.ziingo.fragment.Filter_Fragment;
import com.globussoft.ziingo.fragment.FoodsFragment;
import com.globussoft.ziingo.fragment.GroceriesFragment;
import com.globussoft.ziingo.fragment.HelpFragment;
import com.globussoft.ziingo.fragment.Home_Fragment;
import com.globussoft.ziingo.fragment.MenuList;
import com.globussoft.ziingo.fragment.MyOrdersFragment;
import com.globussoft.ziingo.fragment.NotificationsFragment;
import com.globussoft.ziingo.fragment.OrderStatusFragment;
import com.globussoft.ziingo.fragment.Product_List;
import com.globussoft.ziingo.fragment.RateUsFragment;
import com.globussoft.ziingo.fragment.SettingsFragment;
import com.globussoft.ziingo.fragment.SignOutFragment;
import com.globussoft.ziingo.model.BuyProductModel;
import com.globussoft.ziingo.model.NavDrawerItem;
import com.globussoft.ziingo.model.Items;
import com.globussoft.ziingo.model.RestaurantListModel;
import com.globussoft.ziingo.utills.ConstantUrl;
import com.globussoft.ziingo.utills.Singleton;
import com.globussoft.ziingo.utills.JSONParser;
import com.globussoft.ziingo.utills.Utils2;
//import com.globussoft.ziingo.ui.MultiSwipeRefreshLayout;
import com.globussoft.ziingo.ui.MyCallBack;

//import com.globussoft.ziingo.utills.Utils2;

public class MainActivity extends ActionBarActivity implements MyCallBack {

	public static int mNotificationsCount = 0;
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
	
	SearchAdapter search_adapter;
	List<RestaurantListModel> rlm = new ArrayList<RestaurantListModel>();

	// SwipeRefreshLayout allows the user to swipe the screen down to trigger a
	// manual refresh
	// private MultiSwipeRefreshLayout mSwipeRefreshLayout;

	ArrayList<Items> listDataHeader;
	HashMap<String, List<String>> listDataChild;

	public static Context context;
	public static ImageView toolbarback_image, search_btn, interstial_ad_image,
			close_ads_dialog;
	public static Toolbar toolbar;
	EditText editTextBox;
	public ListView searclist;
	public TextView no_productsl;
	
// public static Dialog adDialog;


	// Search_Ado search_Ado;

	// static ViewPager ads_pager;
	// public static Full_ScreenAds_Adp full_ScreenAds_Adp;
	// int current_page_dealr = 0;
	// public static Timer swipeTimer_dealer = new Timer();
	Dialog dialog;
	public JSONParser parser;

	protected void onCreate(Bundle savedInstanceState) 
	{

		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_main);
		
		dialog = new Dialog(MainActivity.this);
		parser = new JSONParser();
		// Singleton.setshowaddliosteber(this);

		dialog.requestWindowFeature(Window.FEATURE_NO_TITLE);
		dialog.getWindow().setLayout(WindowManager.LayoutParams.MATCH_PARENT,
				WindowManager.LayoutParams.MATCH_PARENT);

		dialog.setContentView(R.layout.dialog_search);

		// Fragment home = new Home_Fragment();
		mManager = getSupportFragmentManager();
		
		FragmentTransaction ftran=mManager.beginTransaction();		
		ftran.replace(R.id.frame_container, new FoodsFragment()).commit();
		
		
		
		/*@Override
		public void onBackPressed() {
		    int fragments = getFragmentManager().getBackStackEntryCount();
		    if (fragments == 1) {
		        finish();
		    }
		    super.onBackPressed();
		}
*/
		

		toolbar = (Toolbar) findViewById(R.id.toolbar);

		toolbarback_image = (ImageView) findViewById(R.id.toolbarback_image);

		if (toolbar != null)
			setSupportActionBar(toolbar);

		//Singleton.myCallBack = this;

		context = getApplicationContext();

		mDrawerTitles = getResources().getStringArray(R.array.nav_drawer_items);
		mDrawerIcons = getResources()
				.obtainTypedArray(R.array.nav_drawer_icons);
		drawerItems = new ArrayList<NavDrawerItem>();
		mDrawerList = (ListView) findViewById(R.id.list_slidermenu);

		for (int i = 0; i < mDrawerTitles.length; i++) {

			drawerItems.add(new NavDrawerItem(mDrawerTitles[i], mDrawerIcons
					.getResourceId(i, -(i + 1))));
		}

		mTitle = mDrawerTitle = getTitle();
		mDrawerLayout = (DrawerLayout) findViewById(R.id.drawer_layout);
		mDrawerToggle = new ActionBarDrawerToggle(this, /* host Activity */
				mDrawerLayout, /* DrawerLayout object */
				toolbar, /* nav drawer icon to replace 'Up' caret */
				R.string.drawer_open, /* "open drawer" description */
				R.string.drawer_close /* "close drawer" description */
				) {

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

		// final ViewGroup footer = (ViewGroup)
		// inflater.inflate(R.layout.footer,
		// mDrawerList, false);

		TextView name_text = (TextView) header.findViewById(R.id.username);

		if (Singleton.firstName != null) 
		{
			name_text.setText(Singleton.firstName);
			/*
			 * if (!Singleton.firstName.equals("")) {
			 * footer.setVisibility(View.INVISIBLE); }
			 */
		}

		/*
		 * RelativeLayout register = (RelativeLayout) footer
		 * .findViewById(R.id.register_rel); RelativeLayout login =
		 * (RelativeLayout) footer .findViewById(R.id.login_rel);
		 * 
		 * register.setOnClickListener(new OnClickListener() {
		 * 
		 * @Override public void onClick(View v) { Intent intent = new
		 * Intent(MainActivity.this, Jewelspark_Signup.class);
		 * 
		 * startActivity(intent);
		 * 
		 * finish();
		 * 
		 * } });
		 * 
		 * login.setOnClickListener(new OnClickListener() {
		 * 
		 * @Override public void onClick(View v) { Intent intent = new
		 * Intent(MainActivity.this, Jewelspark_Signin.class);
		 * 
		 * startActivity(intent);
		 * 
		 * finish(); } });
		 */

		// Give your Toolbar a subtitle!
		/* mToolbar.setSubtitle("Subtitle"); */

		mDrawerList.addHeaderView(header, null, true); // true = clickable
		// mDrawerList.addFooterView(footer, null, true); // true = clickable

		DrawerLayout.LayoutParams lp = (DrawerLayout.LayoutParams) mDrawerList
				.getLayoutParams();
		lp.width = calculateDrawerWidth();
		mDrawerList.setLayoutParams(lp);

		mDrawerList.setAdapter(new NavDrawerListAdapter(
				getApplicationContext(), drawerItems));

		mDrawerList.setOnItemClickListener(new DrawerItemClickListener());

		getSupportActionBar().setDisplayHomeAsUpEnabled(true);

		getSupportActionBar().setHomeButtonEnabled(true);

		 //Fragment fragment = new Home_Fragment();

		// swipeFragment(fragment);

		if (ConstantUrl.isNetworkAvailable(getApplicationContext())
				&& Singleton.user_id != null) {
			 //new GetBag_Details().execute();
		}

	}
/*	@Override
	public void onBackPressed() 
	{
		System.out.println(" I m in OnBackPress button");
	    List<Fragment> fragmentList = getSupportFragmentManager().getFragments();
	    if (fragmentList != null) 
	    {
	        //TODO: Perform your logic to pass back press here
	        for(Fragment fragment : fragmentList)
	        {
	           if(fragment instanceof OnBackPressedListener)
	           {
	               ((OnBackPressedListener)fragment).onBackPressed();
	           }
	           else
		   	    {
		   	    	System.out.println(" I m in OnBackPress NO");
		   	    }
	        }
	    }
	    else
	    {
	    	System.out.println(" I m in OnBackPress fragmentList != null");
	    }
	}*/
	@Override
	public void onBackPressed()	
	{	
		 if (Singleton.previousfragment.equals("Product_List")) {

				System.out.println("Buy_product >>> Product_List");
				Fragment fragment = new Product_List();

				Singleton.previousfragment = "Buy_product";

				Singleton.currentfragment = "Product_List";

				/* mManager.beginTransaction().replace(R.id.frame_container,
				 fragment).commit();
*/
				mManager.popBackStack();
			} 
		
		else if (Singleton.previousfragment.equals("MenuList")) {

			System.out.println("Product_List >>> MenuList ");
			Fragment fragment = new MenuList();

			Singleton.previousfragment = "Product_List";

			Singleton.currentfragment = "MenuList";

			/* mManager.beginTransaction().replace(R.id.frame_container,
			 fragment).commit();*/

			mManager.popBackStack();
		} 
		else if (Singleton.previousfragment.equals("Bag_Fragment")) {

			System.out.println("Bag_Fragment >>> BBAACCKK ");
			//Fragment fragment = new MenuList();

			Singleton.previousfragment = "";

			Singleton.currentfragment = "Bag_Fragment";
			
			finish();

			/* mManager.beginTransaction().replace(R.id.frame_container,
			 fragment).commit();*/

			mManager.popBackStack();
		} 
		 	
		else if (Singleton.previousfragment.equals("FoodsFragment")) {

			System.out.println("MenuList >>> FoodsFragment");
			Fragment fragment = new FoodsFragment();

			Singleton.previousfragment = "MenuList";
			
			Singleton.currentfragment = "FoodsFragment";

			 mManager.beginTransaction().replace(R.id.frame_container,
			 fragment).commit();
			 
			 mManager.popBackStack();
		} 
		
		//if (mManager.getBackStackEntryCount() <1) 
		
		//else if(Singleton.previousfragment.isEmpty())
		 
		else if(mManager.getBackStackEntryCount() <1)
		{
			if (doubleBackToExitPressedOnce) 
			{
				super.onBackPressed();

				return;
			}
			this.doubleBackToExitPressedOnce = true;

			//CommonMethods.showMyToast(MainActivity.this, "Please click BACK again to exit");
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
		// trySetupSwipeRefresh();
	}

	@Override
	public void onConfigurationChanged(Configuration newConfig) 
	{
		super.onConfigurationChanged(newConfig);
		mDrawerToggle.onConfigurationChanged(newConfig);
	}

	/* Called whenever we call invalidateOptionsMenu() */
	@Override
	public boolean onPrepareOptionsMenu(Menu menu) 
	{
		// If the nav drawer is open, hide action items related to the content
		// view
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
			// Profile details
			System.out.println("Clicked on profile");
			// fragment = new FoodsFragment();
			break;

		case 1:
			// Home
			System.out.println("Clicked on Home");
			fragment = new Home_Fragment();
			
			break;

		case 2:
			// Restaurant details
			System.out.println("Clicked on Foods");
			fragment = new FoodsFragment();
			break;
		case 3:
			// Groceries
			System.out.println("Clicked on Groceries");
			fragment = new GroceriesFragment();
			break;

		case 4: 
			// MyOrders
			System.out.println("Clicked on  MyOrders");
			fragment = new MyOrdersFragment();
			break;

		case 5:
			// OrderStatus
			System.out.println("Clicked on OrderStatus");
			fragment = new OrderStatusFragment();
			break;

		/*case 6:
			// Bookmarks
			System.out.println("Clicked on Bookmarks");
			fragment = new BookmarksFragment();
			break;

		case 7:
			// Notifications
			System.out.println("Clicked on Notifications");
			fragment = new NotificationsFragment();
			break;*/

		case 6:
			// Account
			System.out.println("Clicked on  Account");
			fragment = new AccountFragment();
			break;

		case 7:
			// RateUs
			System.out.println("Clicked on RateUs");
			fragment = new RateUsFragment();
			break;

		case 8:
			// FAQs
			System.out.println("Clicked on FAQs");
			fragment = new FAQsFragment();
			break;

		case 9:
			// Settings
			System.out.println("Clicked on Settings");
			fragment = new SettingsFragment();
			break;

		case 10:
			// Help
			System.out.println("Clicked on Help");
			fragment = new HelpFragment();
			break;

		case 11:
			// SignOut
			System.out.println("Clicked on SignOut");
			fragment = new SignOutFragment();
			break;

		default:
			fragment = new FoodsFragment();
			break;

		}

		if (fragment != null) {
			// Insert the fragment by replacing any existing fragment
		mManager.beginTransaction().replace(R.id.frame_container, fragment).commit();
//			swipeFragment(fragment);
		}

		// Highlight the selected item, update the title, and close the drawer
		mDrawerList.setItemChecked(position, true);

		if (position != 0) 
		{
			setTitle(mDrawerTitles[position - 1]);
		}

		mDrawerLayout.closeDrawer(mDrawerList);

	}

	
	public void setTitle(CharSequence title) 
	{
		mTitle = title;
		getSupportActionBar().setTitle(mTitle);
		System.out.println("setTitle");
	}
	

	@Override
	public boolean onCreateOptionsMenu(Menu menu) 
	{

		getMenuInflater().inflate(R.menu.main, menu);

		// Get the notifications MenuItem and LayerDrawable (layer-list)

		if (Build.VERSION.SDK_INT >= 14) 
		{
			MenuItem item = menu.findItem(R.id.action_bag);
			LayerDrawable icon = (LayerDrawable) item.getIcon();

			// Update LayerDrawable's BadgeDrawable
			 Utils2.setBadgeCount(this, icon, mNotificationsCount);
		}

		/*
		 * if (menu.getItem(3).getItemId() == R.id.action_settings) { if
		 * (Singleton.user_id.equals("")) menu.getItem(3).setTitle("Login"); }
		 */

		System.out.println("Oncreate option menu");

		return true;
	}

	@Override
	public boolean onOptionsItemSelected(MenuItem item) 
	{
		System.out.println(" onOptionsItemSelected");

		// Handle action bar item clicks here. The action bar will
		// automatically handle clicks on the Home/Up button, so long
		// as you specify a parent activity in AndroidManifest.xml.
		switch (item.getItemId()) 
		{
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

		else if (item.getItemId() == R.id.action_bag) 
		{

			System.out.println(" Bag clicked");
			
			// Bag Fragment
						
			Fragment fragment = new Bag_Fragment();
			mManager.beginTransaction().replace(R.id.frame_container, fragment).commit();
			
			setTitle("Bag");
		}
		
		else if (item.getItemId() == R.id.action_filter) 
		{

			System.out.println(" Filter clicked");
			
			// Filter Fragment
						
			Fragment fragment = new Filter_Fragment();
			mManager.beginTransaction().replace(R.id.frame_container, fragment).commit();
			
			setTitle("Filter");
		}

		else if (item.getItemId() == R.id.action_search) 
		{
			rlm.clear();
			OpenLocationChnageDialog();
			
			setTitle("Search");
		}
		
		return super.onOptionsItemSelected(item);
	}

	public int calculateDrawerWidth() 
	{
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
		if (android.os.Build.VERSION.SDK_INT >= 13) {
			Point size = new Point();
			display.getSize(size);
			width = size.x;
			height = size.y;
		} else {
			width = display.getWidth(); // deprecated
			height = display.getHeight(); // deprecated
		}
		return width - actionBarHeight;
	}

	private class DrawerItemClickListener implements ListView.OnItemClickListener 
	{
		@Override
		public void onItemClick(AdapterView<?> parent, View view, int position,long id)
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

	public static void MakeToast(String message) {
		Toast.makeText(context, message, Toast.LENGTH_LONG).show();
	}

	public static void swipeFragment(Fragment fragment) 
	{

		mManager.beginTransaction().replace(R.id.frame_container, fragment).addToBackStack(null).commit();	
	}

	static Handler handler = new Handler();

	public void executeThis() {

		handler.post(new Runnable() {

			@Override
			public void run() {

				mDrawerToggle.setDrawerIndicatorEnabled(false);
			}
		});
	}
	
	 public void updateNotificationsBadge(int count) {
	        mNotificationsCount = count;

	        // force the ActionBar to relayout its MenuItems.
	        // onCreateOptionsMenu(Menu) will be called again.
	        invalidateOptionsMenu(); 
	    }
	 
	 public void OpenLocationChnageDialog() {

			editTextBox = (EditText) dialog.findViewById(R.id.editbox);
			searclist = (ListView) dialog.findViewById(R.id.list);
			search_btn = (ImageView) dialog.findViewById(R.id.search_btn);
			no_productsl = (TextView) dialog.findViewById(R.id.no_products);

			search_adapter = new SearchAdapter(getApplicationContext(), rlm);
			searclist.setAdapter(search_adapter);
			
			//enables filtering for the contents of the given ListView
			searclist.setTextFilterEnabled(true);				
			

			searclist.setOnItemClickListener(new OnItemClickListener() {

				@Override
				public void onItemClick(AdapterView<?> parent, View view,
						int position, long id) {

					Singleton.srch_selected_name = rlm.get(
							position).getRest_name();
					
					System.out.println("Singleton.srch_selected_name == "+Singleton.srch_selected_name);
									
					// Singleton.previousfragment = "Product_List";
					// Singleton.currentfragment = "SelectedProductDetails";
					/*Fragment fragment = new SelectedProductDetails();
					mManager.beginTransaction().add(R.id.frame_container, fragment)
							.addToBackStack(null).commit();*/
					
					Fragment fragment = new FoodsFragment();
					mManager.beginTransaction().replace(R.id.frame_container, fragment).commit();					

					dialog.dismiss();
					
					
				}
			});
						 
			editTextBox.addTextChangedListener(new TextWatcher() {

			  public void afterTextChanged(Editable s) {
			  }

			  public void beforeTextChanged(CharSequence s, int start, int count, int after) {
			  }

			  public void onTextChanged(CharSequence s, int start, int before, int count) {
				 // search_adapter.getFilter().filter(s.toString());
				    search_adapter.getItem(start).toString();

			  }
			  });

			search_btn.setOnClickListener(new OnClickListener() {

				@Override
				public void onClick(View v) {

					//rlm.clear();
					//search_adapter.notifyDataSetChanged();

					if (!editTextBox.getText().toString().trim().isEmpty()) {

						/*new FetchProducts().execute(editTextBox.getText().toString().trim());*/
						
						searchRestName();

					} 
					else 
					{
						editTextBox.setError("please give restaurant name");
					}

				}
			});

			if (ConstantUrl.isNetworkAvailable(getApplicationContext())) {
				//new FetchProducts().execute();
				
				searchRestName();
				
				
			} else {
				Toast.makeText(getApplicationContext(), "Please check internet connection!!", Toast.LENGTH_SHORT).show();
			}
			
			dialog.show();

		}
	 
	 public void searchRestName() {
		 
			rlm.clear();
		
			
			for(int i=0; i < Singleton.LocRestNameList.size(); i++) {
				RestaurantListModel restListModel = new RestaurantListModel();
				
				restListModel.setRest_name(Singleton.LocRestNameList.get(i));
				rlm.add(restListModel);
				
			}
			
			search_adapter.notifyDataSetChanged();
	 }
			
			
			/*RequestQueue queue = Volley.newRequestQueue(getApplicationContext());
			StringRequest sr = new StringRequest(Request.Method.GET,
					ConstantUrl.Url_main + ConstantUrl.Url_allhotels,
					new Response.Listener<String>() {
						@Override
						public void onResponse(String response) {							

							
								try {
									JSONObject json = new JSONObject(response);

									System.out.println("restaurant fetch response" + response);

									String msg = json.getString("message");
									
									System.out.println("message >>>>>>>>>" + msg);

									if (json.getString("code").equals("200")) {

										
										JSONArray jsonMainArr = json.getJSONArray("data");


										for (int j = 0; j < jsonMainArr.length(); j++) {
											
											RestaurantListModel restListModel = new RestaurantListModel();
											
											JSONObject childJSONObject = jsonMainArr.getJSONObject(j);

											restListModel.setId(childJSONObject.getString("id"));																				
											restListModel.setRest_name(childJSONObject.getString("hotel_name"));											
											Singleton.RestNameList.add(childJSONObject.getString("hotel_name"));											
											
											bpm.add(restListModel);
											
										}
										
										System.out.println("Singleton.RestNameList == "+Singleton.RestNameList);
									}

									else {

										Toast.makeText(getApplicationContext(),	msg, Toast.LENGTH_LONG).show();
									}

								} catch (Exception e) {
									e.printStackTrace();
								}									

								search_adapter.notifyDataSetChanged();

							
						}

					}, new Response.ErrorListener() {
						@Override
						public void onErrorResponse(VolleyError error) {
							// VolleyLog.d(TAG, "Error: " + error.getMessage());
							System.out.println("Error : " + error);
							// hidePDialog();

						}
					});
			
			queue.add(sr);
		
		 
	 }*/
	
	 /*public class GetBag_Details extends AsyncTask<String, Void, JSONObject> {

		JSONObject json;

		@Override
		protected void onPreExecute() {

			super.onPreExecute();
		
		}

		@Override
		protected JSONObject doInBackground(String... params) {

		

			String url = ConstantUrl.Url_main+ConstantUrl.Url_GetOrders;

			List<NameValuePair> nameValuePair = new ArrayList<NameValuePair>(1);

			nameValuePair.add(new BasicNameValuePair("user_id", Singleton.user_id));

			//nameValuePair.add(new BasicNameValuePair("mytoken",Singleton.mytoken));

			json = parser.getJSONFromUrlByPost(url, nameValuePair);

			System.out.println("BAG Details ="+json);

			return json;
		}

		@Override
		protected void onPostExecute(JSONObject result) {

			super.onPostExecute(result);

			if(result.has("code"))
			{
				try {

					if(result.getInt("code")==200)
					{
						if(result.has("data"))
						{
							JSONArray jsonArray = result.getJSONArray("data");

							if(jsonArray.length()!=0)
							{
								updateNotificationsBadge(jsonArray.length());
							}
						}
					}
					
				} catch (JSONException e) {

					e.printStackTrace();
				}
			}

			
		}
	}*/
	
	@Override
	protected void onResume() {
		// TODO Auto-generated method stub
		super.onResume();
		invalidateOptionsMenu();
	}
	

}